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

$users = new Users($pdoconnect);
$user_arr = $users->getUserPropById($_SESSION['id']);

$validator->validatePassword($user_arr, @$_POST['password'], @$_POST['repassword']);

$forum_edit_validator = new ForumEditValidator($apitools);
$forum_edit_validator->validateImage($_FILE[]);

$forum = new Forum($pdoconnect);

