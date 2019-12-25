<?php

error_reporting(E_ALL); ini_set('display_errors',1);

include "classes/connect.php";
include "classes/Thread.php";
include "classes/ThreadProp.php";

$id = @$_GET['id'];

header('Content-Type: application/json; charset=utf-8');

$thread_arr = array();

$thread = new Thread($pdoconnect);

foreach($thread->getStickyThreadId(2) as $thread_item){
    array_push($thread_arr, $thread_item);
}

foreach($thread->getHomepageNormalThreadId() as $thread_item){
    array_push($thread_arr, $thread_item);
}


print_r(json_encode($thread_arr));

