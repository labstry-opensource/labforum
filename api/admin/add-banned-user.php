<?php

session_start();
include_once @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/connect.php";
include_once @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/UserRoles.php";
include_once @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/Users.php";
include_once @$_SERVER["DOCUMENT_ROOT"]."/api/forum/classes/BlockList.php";

$users = new Users($pdoconnect, "");
$roles = new UserRoles($pdoconnect);
$bl = new BlockList($pdoconnect);

$userrights = $roles->getUserRole(@$_SESSION['id']);

$data =array();


if(!@$_SESSION["id"] || $userrights["rights"] < 90 ){

	//Forbid users with rights lower than 90 from accessing to this api

    header("HTTP/2.0 403 Forbidden");
    die('403 Forbidden');
}

header('Content-Type: application/json; charset=utf-8');

if(!@$_POST["id"]){
	$data["error"] = "Please provide an id";
	echo json_encode($data);
	die();
}

if(!@$_POST["end_date"]) $end_date = null;
else $end_date = @$_POST["end_date"];

if(!@$_POST["reason"]) $reason = null;
else $reason = @$_POST["reason"];


$bl->addToBlockList(@$_POST["id"], $end_date, $reason);

$data["success"] = "Added user to banned list";

echo json_encode($data);

