<?php

include dirname(__FILE__)."/../classes/Users.php";
include dirname(__FILE__)."/../classes/connect.php";
include dirname(__FILE__)."/../classes/APITools.php";

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





