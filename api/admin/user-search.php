<?php

include dirname(__FILE__) . '/../../laf-config.php';
include API_PATH . "/classes/Users.php";
include API_PATH . "/classes/connect.php";
include API_PATH . "/classes/APITools.php";

$apitools = new APITools();

$data = array();

$username = @$_POST["username"];

if(!$username){
	$data["error"] = "No username is provided";
}else{
	$users = new Users($pdoconnect, "");
	$data = $users->searchUsername($username);
}

$apitools->outputContent($data);





