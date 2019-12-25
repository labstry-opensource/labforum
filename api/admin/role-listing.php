<?php

session_start();
header('Content-Type: application/json');

include @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/Users.php";
include @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/connect.php";
include @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/UserRoles.php";


$users = new Users($pdoconnect, "");
$roles = new UserRoles($pdoconnect);

$data = array();

$right_data = $roles->getUserRole(@$_SESSION["id"]);

if(!@$_SESSION['id'] || $right_data["rights"] < 90){
	$data["error"] = "Please make sure you know what you are doing.";
	die(json_encode($data));
}

$data = $roles->getAllRoles();

echo json_encode($data);