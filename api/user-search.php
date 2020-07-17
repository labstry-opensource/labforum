<?php

include_once dirname(__FILE__) . '/../autoload.php';

$apitools = new APITools($pdoconnect);

$data = array();

$username = isset($_POST['username']) ? $_POST['username'] : '';

if(empty($username)){
	$data['data']["error"] = "No username is provided";
}else{
	$users = new Users($pdoconnect, "");
	$data = $users->searchUsername($username);
}

$apitools->outputContent($data);





