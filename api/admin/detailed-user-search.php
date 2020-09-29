<?php

include_once dirname(__FILE__) . '/../../autoload.php';

$users = new Users($connection);
$roles = new UserRoles($connection);
$apitools = new APITools();

$data = array();


$right_data = $roles->getUserRole(@$_SESSION["id"]);

if(empty($_POST['id']) || $right_data["rights"] < 90 || isset($_SESSION["id"])){
	$data["error"] = "Please make sure you know what you are doing.";
	$apitools->outputContent($data);
}

$data = $users->getUserPropById(@$_POST["id"]);
$data["rights"] = $roles->getUserRole(@$_POST["id"]);

$apitools->outputContent($data);

