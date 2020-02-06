<?php
session_start();
include dirname(__FILE__) . "/../laf-config.php";
include dirname(__FILE__) . "/classes/connect.php";
include dirname(__FILE__) . "/classes/APITools.php";
include dirname(__FILE__) . '/classes/Forum.php';
include dirname(__FILE__) . '/classes/ThreadOperation.php';
include dirname(__FILE__) . '/classes/UserRoles.php';
include LAF_PATH . '/../vendor/HTMLPurifier.standalone.php';


$_SESSION['id'] = 2;

$error_msg = array(
    'not_logged_in' => '發帖前必須登入',
    'no_forum_selected' => '請選擇發帖論壇',
    'forum_not_exist' => '選擇的論壇不存在',
    'no_rights' => '你沒有權限在本版發帖',
    'topic_empty' => '帖子內容不能為空白',
    'content_empty' => '帖子主題不能為空白',
    'content_too_short' => '帖子內容必須大於 6 個字符',
    'topic_too_short' => '帖子主題必須大於或等於 2 個字符及少於 30 個字符',
    'read_permission_not_in_range' => '權限必須介乎 0-255 之間',
);

$apitools = new APITools();

if(!isset($_SESSION['id'])){
    $data['error']['not_logged_in'] = $error_msg['not_logged_in'] ;
    $apitools->outputContent($data);
}

if(!isset($_POST['forum'])){
    $data['error']['forum'] = $error_msg['no_forum_selected'];
    $apitools->outputContent($data);

}
$forum = new Forum($pdoconnect);

if(!$forum->checkHasForum($_POST['forum'])){
    $data['error']['forum'] = $error_msg['forum_not_exist'];
}

if(!isset($_POST['action'])){
    $roles = new UserRoles($pdoconnect);
    $role_detail = $roles->getUserRole($_SESSION['id']);
    if(!$forum->hasRightsToAuthorInForum($_POST['forum'], $role_detail['rights'])){
        $data['error']['forum'] = $error_msg['no_rights'];
    }

    if(empty($_POST['thread_content'])){
        $data['error']['thread_content'] = $error_msg['content_empty'];
    }
    if(empty($_POST['thread_topic'])){
        $data['error']['thread_topic'] =  $error_msg['topic_empty'];
    }

    $content_word_count = str_word_count(strip_tags($_POST['thread_content']));
    $topic_word_count = str_word_count(strip_tags($_POST['thread_topic']));
    if($topic_word_count < 2 && $topic_word_count > 30){
        $data['error']['thread_topic'] =  $error_msg['topic_too_short'];
    }

    if($content_word_count < 6) {
        $data['error']['thread_content'] =  $error_msg['content_too_short'];
    }

    if(!isset($_POST['read_permission']) || !ctype_digit($_POST['read_permission']) ||
        $_POST['read_permission'] < 0 || $_POST['read_permission'] > 255){
        $data['error']['read_permission'] =  $error_msg['read_permission_not_in_range'];
    }

    if(!empty($data['error'])){
        $apitools->outputContent($data);
    }

    $read_permission = isset($_POST['read_permission']) ? $_POST['read_permission'] : 0;
    $draft_mode = isset($_POST['draft']) ? true: false;


    $config = HTMLPurifier_Config::createDefault();

    $purifier = new HTMLPurifier($config);
    $operation = new ThreadOperation($pdoconnect, '', '');

    $thread = array(
        'author' => $_SESSION['id'],
        'fid' => $_POST['forum'],
        'thread_topic' => $purifier->purify($_POST['thread_topic']),
        'thread_content' => $purifier->purify($_POST['thread_content']),
        'rights' => $read_permission,
        'draft' => $draft_mode,

    );
    $thread_id = $operation->postThread($thread);

    $data['success'] = array(
      'msg' => 'Thread posted.',
      'thread_id' => $thread_id,
    );
    $apitools->outputContent($data);
}
