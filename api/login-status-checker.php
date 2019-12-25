<?php
//Check whether user logged in
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header('Content-Type: application/json');

include_once "classes/connect.php";
include_once "classes/Users.php";
include_once "classes/UserRoles.php";

$data = array();

if(!@$_SESSION["id"]){
	$data["is_logged_in"] = false;
	echo json_encode($data);
	exit;
}

$data["is_logged_in"] = true;

$userid = @$_SESSION["id"];
$users = new Users($pdoconnect, "");
$userole = new UserRoles($pdoconnect);

$data["user"] = $users->getSafeUserPropById($userid);
$data["user"]["roles"] = $userole->getUserRole($userid);

echo json_encode($data);

?>