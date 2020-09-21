<?php

include_once dirname(__FILE__) . '/../../autoload.php';


$msg = include LAF_ROOT_PATH .'/locale/' . LANGUAGE . '/admin/api-add-banned-user.php';

$users = new Users($connection);
$roles = new UserRoles($pdoconnect);
$bl = new BlockList($connection);
$apitools = new APITools();



$userrights = isset($_SESSION['id']) ? $roles->getUserRole($_SESSION['id']) : array();

$data['data'] = array();

if(!isset($_SESSION['id']) || $userrights['rights'] < 90 ){
	//Forbid users with rights lower than 90 from accessing to this api
    http_response_code(403);
    die('403 Forbidden');
}

if(!isset($_POST["id"])){
	$data['data']["error"] = "Please provide an id";
	$apitools->outputContent($data);
	die();
}

$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
$reason = isset($_POST['reason']) ? $_POST['reason'] : null;


$bl->addToBlockList($_POST["id"], $end_date, $reason);

$data['data']["success"] = "Added user to banned list";

$apitools->outputContent($data);

