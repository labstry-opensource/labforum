<?php
include dirname(__FILE__) . "/../laf-config.php";
include API_PATH . "/classes/connect.php";
include API_PATH . "/classes/Thread.php";
include API_PATH . "/classes/APITools.php";
include API_PATH . "/classes/UserRoles.php";

if(!isset($_SESSION)) session_start();

$apitools = new APITools();

if(!isset($_GET['id'])){
    $data['error'] = 'Please specify thread id';
    $apitools->outputContent($data);
}

$thread = new Thread($pdoconnect);

if(!$thread->checkHasSuchThread($_GET['id'])){
    $data['error'] = 'No such thread !';
    $apitools->outputContent($data);
}

$roles = new UserRoles($pdoconnect);
$roles_arr = $roles->getUserRole(@$_SESSION['id']);

$data = $thread->getThreadProp($_GET['id']);
if($data['rights'] > $roles_arr['rights']){
    $data['error'] = 'You have no rights to view this thread.';
    $apitools->outputContent($data);
}

if(isset($_GET['reply'])){
    $output = $thread->getReplyPropById($_GET['id'], $_GET['reply']);
}else{
    $output = $data;
}



$apitools->outputContent($output);


