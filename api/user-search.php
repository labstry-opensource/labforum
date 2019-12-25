<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/Users.php";
include @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/connect.php";

header('Content-Type: application/json');

$data = array();

$username = @$_POST["username"];

if(!$username){
	$data["error"] = "No username is provided";
}else{
	$users = new Users($pdoconnect, "");
	$data = $users->searchUsername($username);
}
echo json_encode($data);





