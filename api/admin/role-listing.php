<?php

session_start();
header('Content-Type: application/json');

include dirname(__FILE__ ) . '/../../laf-config.php';
include LAF_PATH ."/../classes/Users.php";
include LAF_PATH ."/../classes/connect.php";
include LAF_PATH ."/../classes/UserRoles.php";

//1. Check if user logged in
if(!@$_SESSION['id']){
    $data["error"] = "Please login before proceeding.";
    echo json_encode($data);
    exit;
}

$users = new Users($pdoconnect, "");
$roles = new UserRoles($pdoconnect);

$data = array();


$right_data = $roles->getUserRole(@$_SESSION["id"]);


$data = $roles->getAllRoles();

echo json_encode($data);