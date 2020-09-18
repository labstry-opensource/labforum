<?php

include_once dirname(__FILE__) . '/../../autoload.php';

//1. Check if user logged in
if(!@$_SESSION['id']){
    $data["error"] = "Please login before proceeding.";
    echo json_encode($data);
    exit;
}

$users = new Users($connection);
$roles = new UserRoles($pdoconnect);

$data = array();


$right_data = $roles->getUserRole(@$_SESSION["id"]);


$data = $roles->getAllRoles();

echo json_encode($data);