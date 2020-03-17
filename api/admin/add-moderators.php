<?php
session_start();

include dirname(__FILE__) . '/../../laf-config.php';
include_once API_PATH . '/classes/connect.php';
include_once API_PATH . '/classes/Users.php';
include_once API_PATH . "/classes/UserRoles.php";
include_once API_PATH . "/classes/Validator.php";
include_once API_PATH . "/classes/APITools.php";
include_once API_PATH . "/classes/Forum.php";

$apitools = new APITools();
$validator = new Validator($apitools);

//Never trust user input
$validator->validateLoggedIn(@$_SESSION['id']);

$roles = new UserRoles($pdoconnect);
$roles_arr = $roles->getUserRole($_SESSION['id']);

$validator->validateAdmin($roles_arr['rights']);

$users = new Users($pdoconnect);
$user_arr = $users->getUserPropById($_SESSION['id']);

$validator->validatePassword($user_arr, @$_POST['password'], @$_POST['repassword']);

if(empty($_POST['fid'])){
    $data["error"]['fid'] = "Please specify a sub-forum to continue";
    $apitools->outputContent($data);
}

$forum = new Forum($pdoconnect);
if(!$forum->checkHasForum($_POST['fid'])){
    $data["error"]['fid'] = "Forum specified doesn't exists.";
    $apitools->outputContent($data);
}

if(empty($_POST['username'])){
    $data["error"]['fid'] = "Please choose a user to be a mod.";
    $apitools->outputContent($data);
}

foreach($_POST['username'] as $user){
    $forum->addModerator($_POST['fid'], $user);
}

$data['success'] = true;
$apitools->outputContent($data);




