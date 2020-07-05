<?php
if(!isset($_SESSION)) session_start();

include dirname(__FILE__) . '/../autoload.php';
include LAF_ROOT_PATH . '/vendor/HTMLPurifier.standalone.php';

$apitools = new APITools();
$msg = include LAF_ROOT_PATH .'/locale/' . LANGUAGE . '/api-post-reply.php';

$roles = new UserRoles($pdoconnect);
$validator = new ThreadValidator($apitools, '');
$thread = new Thread($pdoconnect);
$config = HTMLPurifier_Config::createDefault();
$config->set('HTML.SafeIframe', true);
$config->set('URI.SafeIframeRegexp', '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%');
$purifier = new HTMLPurifier($config);

if(!isset($_POST['thread_id'])){
    $data['error']['thread_id'] = 'No thread specified';
    $apitools->outputContent($data);
}


if(!$thread->checkHasSuchThread($_POST['thread_id'])){
    $data['error']['thread_id'] = 'No such thread';
    $apitools->outputContent($data);
}

$validator->validateIdentity(@$_SESSION['id']);
$validator->validateReply($_POST);

$reply = array(
    'reply_topic' => $purifier->purify($_POST['reply_topic']),
    'reply_content' => $purifier->purify($_POST['reply_content']),
    'thread_id' => $_POST['thread_id'],
    'author' => $_SESSION['id'],
);

$operation = new ThreadOperation($pdoconnect, '', '');
$operation->postReply($reply);

$data['success'] = true;
$apitools->outputContent($data);