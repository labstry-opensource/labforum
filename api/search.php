<?php

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include "classes/connect.php";
include "classes/Thread.php";

header('Content-Type: application/json; charset=utf-8');

if(!isset($_GET['keyword'])){
    print_r(json_encode('')); exit;
}

$thread = new Thread($pdoconnect);
$search_thread = $thread->searchThreadByName($_GET['keyword']);

ob_start('ob_gzhandler');
echo $search_thread;
ob_end_flush();

exit;