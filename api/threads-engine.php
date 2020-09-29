<?php
include_once dirname(__FILE__) . '/../autoload.php';

$api_tools = new APITools();
$thread = new Thread($pdoconnect);
$forum = new Forum($connection);
$roles = new UserRoles($connection);

$page = isset($_GET['page']) ? $_GET['page'] : '';
$fid = isset($_GET['fid']) ? $_GET['fid'] : '';

//No rights for guests
$rights = (isset($_SESSION['username'])) ? $roles->getUserRole($_SESSION['username']) : 0;

if(!isset($_GET['fid']) && !isset($_GET['page']) && !isset($_GET['id'])){
    $data['error'] = 'Please specify a page or fid to get data';
    $api_tools->outputContent($data);
}


if(!$fid && $page === 'home'){
    //Getting homepage contents
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

}
else if(!empty($fid)){
    if(!$forum->hasRightsToViewForum($fid, $rights)){
        $data['data']['error'] = 'You have no rights to view this forum';
        $api_tools->outputContent($data);
    }
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
    $roles = new UserRoles($connection);
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

    $operation = new ThreadOperation($connection);
    $thread_arr['history'] = $operation->getThreadLog($thread_id);

    $api_tools->outputContent($thread_arr);
}