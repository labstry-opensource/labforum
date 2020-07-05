<?php

include_once dirname(__FILE__) . '/../../autoload.php';

$data = array();
$apitools = new APITools();

//1. Check if user logged in
if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
    $data["error"] = "Please login before proceeding.";
    $apitools->outputContent($data);
    exit;
}

$users = new Users($pdoconnect, "");
$userprop = new UserRoles($pdoconnect);
$right_info = $userprop->getUserRole(isset($_SESSION['id']));


if($right_info["rights"] < 90){
	$data["error"] = "You don't have sufficient right to reserve username.";
	$apitools->outputContent($data);
	exit;
}

//All restriction cleared. Now we accept post contents
if(!isset($_POST["action"])){
	$data["error"] = "Please specify action required.";
    $apitools->outputContent($data);
	exit;
}


if($_POST['action'] === 'useradd'){
	$username = $_POST["reserve_username"];

	if(!isset($username)){
		$data["error"] = "Please input a username";
		$apitools->outputContent($data);
		exit;
	}

	$result = $users->reserveUsername($_SESSION["id"], $username);

	switch ($result) {
		case 0:
			$data["error"] = "The username has already been reserved. Please choose a different one";
			break;
		
		case 1:
			$data["success"] = "The username is reserved";
			break;
	}

	$apitools->outputContent($data);
}

if($_POST["action"] === "userdelete"){
	$username = isset($_POST["reserve_username"]) ? $_POST['reserve_username'] : '';
	if(empty($username)){
		$data["error"] = "Please specify a username to remove";
        $apitools->outputContent($data);
		exit;
	}

	$users->deleteReservedUsername($username);
	$data["success"] = "The reserved username is deleted";
    $apitools->outputContent($data);
	
}