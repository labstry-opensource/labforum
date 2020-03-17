<?php
include dirname(__FILE__) . "/../laf-config.php";
include API_PATH . "/classes/connect.php";
include API_PATH . "/classes/Thread.php";
include API_PATH . "/classes/ThreadOperation.php";
include API_PATH . "/classes/APITools.php";
include API_PATH . "/classes/ThreadProp.php";
include API_PATH . "/classes/Forum.php";
include API_PATH . "/classes/UserRoles.php";


$api_tools = new APITools();
$thread = new Thread($pdoconnect);
$forum = new Forum($pdoconnect);

if(!isset($_GET['fid']) && !isset($_GET['page']) && !isset($_GET['id'])){
    $data['error'] = 'Please specify a page or fid to get data';
    $api_tools->outputContent($data);
}


if(@$_GET['page'] === 'home'){
    $thread_arr = array();
    foreach ($thread->getStickyThreadId(2) as $thread_item) {
        $thread_item['number_of_replies'] = $thread->getNumberOfReplies($thread_item['topic_id']);
        array_push($thread_arr, $thread_item);
    }

    foreach ($thread->getHomepageNormalThreadId() as $thread_item) {
        $thread_item['number_of_replies'] = $thread->getNumberOfReplies($thread_item['topic_id']);
        array_push($thread_arr, $thread_item);
    }

    $api_tools->outputContent($thread_arr);

}else if(@$_GET['fid']){
    $fid = $_GET['fid'];
    $forum_thread_count = $forum->countThreads($fid);

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $count = isset($_GET['count']) ? (int) $_GET['count'] : 10;

    $from_page = ($page - 1) * $count;
    $to_page = $page * $count;

    $data['pages'] = ceil($forum_thread_count / $count);
    $data['current_page'] = $page;
    $data['data'] = $thread->getThreadsByFid($fid, $from_page, $to_page);

    foreach($data['data'] as $key => $thread_item){
        $data['data'][$key]['number_of_replies'] = $thread->getNumberOfReplies($thread_item['topic_id']);
    }


    $api_tools->outputContent($data);

}else if (isset($_GET['id'])){
    $thread_id = $_GET['id'];
    if(!$thread->checkHasSuchThread($thread_id)){
        $data['error'] = 'No such thread';
        $api_tools->outputContent($data);
    }
    $thread->addViews($thread_id);
    $thread_arr = $thread->getThreadProp($thread_id);

    //Get user roles and tag color
    $roles = new UserRoles($pdoconnect);
    $role_arr = $roles->getUserRole($thread_arr['author']);

    if($thread_arr['rights'] > $role_arr['rights']){
        $data['error'] = 'You have no rights to view this thread.';
        $apitools->outputContent($data);
    }

    $thread_arr['role'] = $role_arr['role_name'];
    $thread_arr['role_color'] = isset($role_arr['tagcolor'])? $role_arr['tagcolor'] : '#000';
    $thread_arr['replies'] = $thread->getReplies($thread_id);

    foreach($thread_arr['replies'] as $index => $reply){
        $role_arr = $roles->getUserRole($reply['author']);
        $thread_arr['replies'][$index]['role'] = $role_arr['role_name'];
        $thread_arr['replies'][$index]['tag_color'] = isset($role_arr['tagcolor'])? $role_arr['tagcolor'] : '#000';
    }

    $operation = new ThreadOperation($pdoconnect);
    $thread_arr['history'] = $operation->getThreadLog($thread_id);

    $api_tools->outputContent($thread_arr);
}