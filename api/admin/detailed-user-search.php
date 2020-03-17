<?php

session_start();
header('Content-Type: application/json');

include dirname(__FILE__) . '/../../laf-config.php';
include API_PATH ."/classes/Users.php";
include API_PATH ."/classes/connect.php";
include API_PATH ."/classes/UserRoles.php";


$users = new Users($pdoconnect, "");
$roles = new UserRoles($pdoconnect);

$data = array();

$right_data = $roles->getUserRole(@$_SESSION["id"]);

if(!@$_POST['id'] || $right_data["rights"] < 90 || !@$_SESSION["id"]){
	$data["error"] = "Please make sure you know what you are doing.";
	die(json_encode($data));
}

$data = $users->getUserPropById(@$_POST["id"]);
$data["rights"] = $roles->getUserRole(@$_POST["id"]);

echo json_encode($data);

