<?php
//Check whether user logged in
if(!isset($_SESSION)) session_start();
include_once dirname(__FILE__) . '/../autoload.php';

$data = array();
$apitools = new APITools($pdoconnect);

if(!isset($_SESSION["id"])){
	$data["is_logged_in"] = false;
	$apitools->outputContent($data);
	exit;
}

$data["is_logged_in"] = true;

$userid = $_SESSION["id"];
$users = new Users($pdoconnect, "");
$userole = new UserRoles($pdoconnect);

$data["user"] = $users->getSafeUserPropById($userid);
$data["user"]["roles"] = $userole->getUserRole($userid);

$apitools->outputContent($data);