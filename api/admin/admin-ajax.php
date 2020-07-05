<?php

include_once dirname(__FILE__) . '/../../autoload.php';
$apitools = new APITools();
$validator = new Validator($apitools);

//Validate user logged in . Only admin can use this ajax.
$validator->validateLoggedIn(@$_SESSION['id']);
$roles = new UserRoles($pdoconnect);
$roles_arr = $roles->getUserRole($_SESSION['id']);
$validator->validateAdmin($roles_arr['rights']);


$data['data'] = array(
    'success' => true,
);

$apitools->outputContent($data);