<?php
session_start();
include dirname(__FILE__) . "/../laf-config.php";
include dirname(__FILE__) . "/classes/connect.php";
include dirname(__FILE__) . "/classes/APITools.php";
include dirname(__FILE__) . '/classes/Forum.php';
include dirname(__FILE__) . '/classes/ThreadOperation.php';
include dirname(__FILE__) . '/classes/Thread.php';
include dirname(__FILE__) . '/classes/ThreadValidator.php';
include dirname(__FILE__) . '/classes/UserRoles.php';
include LAF_PATH . '/../vendor/HTMLPurifier.standalone.php';


$apitools = new APITools();

$forum = new Forum($pdoconnect);
$config = HTMLPurifier_Config::createDefault();
$config->set('HTML.SafeIframe', true);
$config->set('URI.SafeIframeRegexp', '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%');
$purifier = new HTMLPurifier($config);


if(!isset($_GET['action']) || $_GET['action'] === 'compose'){
    $roles = new UserRoles($pdoconnect);
    $role_detail = $roles->getUserRole($_SESSION['id']);
    $read_permission = isset($_POST['read_permission']) ? $_POST['read_permission'] : 0;

    $validator = new ThreadValidator($apitools, $forum);
    $validator->validatePostedContent($_POST);

    $thread_arr = array(
        'thread_topic' => $_POST['thread_topic'],
        'thread_content' => $_POST['thread_content'],
    );

    $validator->validateIdentity($_SESSION['id']);
    $validator->validateForum($_POST['forum']);
    $validator->validateAuthorRights($_POST['forum'], $role_detail['rights']);
    $validator->validateThread($thread_arr);
    $validator->validateReadPermission($read_permission);

    $draft_mode = isset($_POST['draft']) ? '1' : '0';

    $operation = new ThreadOperation($pdoconnect, '', '');


    $thread = array(
        'author' => $_SESSION['id'],
        'fid' => $_POST['forum'],
        'thread_topic' => $purifier->purify($_POST['thread_topic']),
        'thread_content' => $purifier->purify($_POST['thread_content']),
        'rights' => $read_permission,
        'draft' => $draft_mode,
        'keyword' => $purifier->purify($_POST['introduction']),
    );

    $thread_id = $operation->postThread($thread);

    $data['success'] = array(
      'msg' => 'Thread posted.',
      'thread_id' => $thread_id,
    );
    $apitools->outputContent($data);

}else if($_GET['action'] === 'edit'){
    $thread = new Thread($pdoconnect);
    $thread_details = $thread->getThreadProp($_GET['id']);


    $read_permission = isset($_POST['read_permission']) ? $_POST['read_permission'] : 0;
    $draft_mode = isset($_POST['draft']) ? true: false;

    $roles = new UserRoles($pdoconnect);

    $draft_mode = isset($_POST['draft']) ? '1' : '0';

    $validator = new ThreadValidator($apitools, $forum);
    $validator->validatePostedContent($_POST);
    $validator->validateIdentity(@$_SESSION['id']);

    $role_detail = $roles->getUserRole(@$_SESSION['id']);

    $thread_arr = array(
        'thread_topic' => $_POST['thread_topic'],
        'thread_content' => $_POST['thread_content'],
    );

    $validator->validateEditRights($thread_details, $role_detail);
    $validator->validateThread($thread_arr);
    $validator->validateReadPermission($read_permission);


    $operation = new ThreadOperation($pdoconnect, '', '');
    $thread = array(
        'id' => $_GET['id'],
        'thread_topic' => $purifier->purify($_POST['thread_topic']),
        'thread_content' => $purifier->purify($_POST['thread_content']),
        'read_permission' => $read_permission,
        'draft' => $draft_mode,
        'keyword' => $purifier->purify($_POST['introduction']),
    );
    $operation->editThread($thread);

    $data['success'] = array(
        'msg' => 'Thread saved.',
        'thread_id' => $_GET['id'],
    );
    $apitools->outputContent($data);
}

