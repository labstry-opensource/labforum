<?php
include dirname(__FILE__) . '/../laf-config.php';
include dirname(__FILE__) . "/classes/connect.php";
include dirname(__FILE__) . "/classes/Thread.php";
include dirname(__FILE__) . "/classes/APITools.php";

header('Content-Type: application/json; charset=utf-8');

$apitools = new APITools($pdoconnect);

if(!isset($_GET['id'])){
    $data['error'] = 'No thread ID is specified';
    $apitools->outputContent($data);
}

$id = $_GET['id'];
$thread = new Thread($pdoconnect);

echo $thread->getDescription($id);