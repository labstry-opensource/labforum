<?php

include_once dirname(__FILE__) . '/../../autoload.php';

$apitools = new APITools();

$data = array();

if(isset($_POST['type']) && $_POST['type'] === 'individual'){
    $users = new Users($pdoconnect, "");
    $roles = new UserRoles($pdoconnect);
    $right_data = $roles->getUserRole(@$_SESSION["id"]);

    if(empty($_POST['id']) || $right_data["rights"] < 90 || isset($_SESSION["id"])){
        $data["error"] = "Please make sure you know what you are doing.";
        $apitools->outputContent($data);
    }

    $data = $users->getUserPropById(@$_POST["id"]);
    $data["rights"] = $roles->getUserRole(@$_POST["id"]);

    $apitools->outputContent($data);
}

$username = @$_POST["username"];

if(!$username){
	$data["error"] = "No username is provided";
}else{
	$users = new Users($pdoconnect, "");
	$data = $users->searchUsername($username);
}

$apitools->outputContent($data);





