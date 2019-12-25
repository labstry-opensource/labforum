<?php


session_start();

$data = array();
header('Content-Type: application/json');

include @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/connect.php";
include @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/UserRoles.php";
include @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/Users.php";

$users = new Users($pdoconnect, "");
$userprop = new UserRoles($pdoconnect);
$right_info = $userprop->getUserRole(@$_SESSION['id']);


//1. Check if user logged in
if(!@$_SESSION['id']){
	$data["error"] = "Please login before proceeding.";
	echo json_encode($data);
	exit;
}


if($right_info["rights"] < 90){
	$data["error"] = "Make sure you have sufficient permission before proceeding.";
	echo json_encode($data);
	exit;
}

//All restriction cleared. Now we accept post contents

if(!@$_POST["action"]){
	$data["error"] = "Please specify action required.";
	echo json_encode($data);
	exit;
}

if(@$_POST['action'] == 'useradd'){
	$username = @$_POST["reserve_username"];

	if(!$username){
		$data["error"] = "Please input a username";
		echo json_encode($data);
		exit;
	}

	$result = $users->reserveUsername(@$_SESSION["id"], $username);

	switch ($result) {
		case 0:
			$data["error"] = "The username has already been reserved. Please choose a different one";
			break;
		
		case 1:
			$data["success"] = "The username is reserved";
			break;
	}

	echo json_encode($data);
}

if(@$_POST["action"] == "userdelete"){
	$username = @$_POST["reserve_username"];
	if(!$username){
		$data["error"] = "Please specify a username to remove";
		echo json_encode($data);
		exit;
	}

	$users->deleteReservedUsername($username);
	$data["success"] = "The reserved username is deleted";
	echo json_encode($data);
	
}




