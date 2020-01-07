<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "classes/connect.php";
include "classes/Thread.php";
include "classes/ThreadProp.php";

$id = @$_GET['id'];



$thread = new Thread($pdoconnect);

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
    header('Content-Type: application/json; charset=utf-8');
    print_r(json_encode($thread_arr));
    exit;
}else{
    $id = @$_GET['id'];
    $resultarr = $thread->getThreadProp($id);
    // Get reply count
    $resultarr['reply_count'] = $thread->getNumberOfReplies($id);
    $resultarr['replies'] = array();

    if ((! @$_GET['reply_from']) || (! @$_GET['reply_to'])) {
        $reply_from = 1;
        $reply_to = $resultarr['reply_count'];
    } else {
        $reply_from = @$_GET['reply_from'];
        $reply_to = @$_GET['reply_to'];
    }

    for ($i = $reply_from; $i <= $reply_to; $i++ ) {
        if ($i > $resultarr["reply_count"]){
            break;
        }
        $replyprop = new ReplyProp($pdoconnect, '', $id, $i);
        array_push($resultarr['replies'], $replyprop->getThreadProp());
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($resultarr);
    exit;

}
