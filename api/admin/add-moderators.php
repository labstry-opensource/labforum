<?php

include_once dirname(__FILE__) . '/../../autoload.php';

$apitools = new APITools();
$validator = new Validator($apitools);

//Never trust user input
$validator->validateLoggedIn(@$_SESSION['id']);

$roles = new UserRoles($connection);
$roles_arr = $roles->getUserRole($_SESSION['id']);

$validator->validateAdmin($roles_arr['rights']);

$users = new Users($connection);
$user_arr = $users->getUserPropById($_SESSION['id']);

$validator->validatePassword($user_arr, @$_POST['password'], @$_POST['repassword']);

if(empty($_POST['fid'])){
    $data["error"]['fid'] = "Please specify a sub-forum to continue";
    $apitools->outputContent($data);
}

$forum = new Forum($connection);
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




