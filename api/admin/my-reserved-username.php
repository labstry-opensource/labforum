<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$data = array();
header("Content-Type: application/json");
include_once  dirname(__FILE__) . '/../../laf-config.php';
include_once  dirname(__FILE__) . "/../classes/connect.php";
include_once  dirname(__FILE__) . "/../classes/Users.php";

if(!@$_SESSION['id']){
	//$data["error"] = "Please login before proceeding.";
	//echo json_encode($data);
	//exit;
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