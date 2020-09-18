<?php

include_once dirname(__FILE__) . '/../../autoload.php';
$apitools = new APITools();
$validator = new Validator($apitools);

//Never trust user input
$validator->validateLoggedIn(@$_SESSION['id']);

$roles = new UserRoles($pdoconnect);
$roles_arr = $roles->getUserRole($_SESSION['id']);

$validator->validateAdmin($roles_arr['rights']);

$userrole = new UserRoles($pdoconnect);
$roles_arr = $userrole->getUserRole($_SESSION['id']);

$apitools->imposeRightRestriction(90, $roles_arr['rights']);

$users = new Users($connection);
$user_arr = $users->getUserPropById($_SESSION['id']);

$validator->validatePassword($user_arr, @$_POST['password'], @$_POST['repassword']);

if(!$_FILES['forum-hero-image'])
$path = pathinfo($_FILES['forum-hero-image']['name'], PATHINFO_EXTENSION);
if(!in_array($path, $this->accepted_types)){
    $data['error'] = 'Not an image';
    $this->apitools->outputContent($data);
}
$forum = new Forum($pdoconnect);

