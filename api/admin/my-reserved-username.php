<?php

session_start();
$data = array();
include_once  dirname(__FILE__) . '/../../autoload.php';

if(!@$_SESSION['id']){
	//$data["error"] = "Please login before proceeding.";
	//echo json_encode($data);
	//exit;
}

$users = new Users($connection);

//casting to new name
$reserved_username = $users->getReservedUsername(@$_SESSION['id']);

$username_array = array();
foreach ($reserved_username as $username) {
	array_push($username_array, $username);
}

$data["username"] = $username_array;

echo json_encode($data);