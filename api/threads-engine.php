<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include dirname(__FILE__) . "/classes/connect.php";
include dirname(__FILE__) . "/classes/Thread.php";
include dirname(__FILE__) . "/classes/APITools.php";
include dirname(__FILE__) . "/classes/ThreadProp.php";
include dirname(__FILE__) . "/classes/Forum.php";


$api_tools = new APITools();
$thread = new Thread($pdoconnect);
$forum = new Forum($pdoconnect);

if(!isset($_GET['fid']) && !isset($_GET['page'])){
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

}else{
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


}