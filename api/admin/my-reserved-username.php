<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$data = array();
header("Content-Type: application/json");

include @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/connect.php";
include @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/Users.php";

if(!@$_SESSION['id']){
	$data["error"] = "Please login before proceeding.";
	echo json_encode($data);
	exit;
}

$users = new Users($pdoconnect, "");

//casting to new name
$reserved_username = $users->getReservedUsername(@$_SESSION['id']);

$username_array = array();
foreach ($reserved_username as $username) {
	array_push($username_array, $username);
}

$data["username"] = $username_array;

echo json_encode($data);