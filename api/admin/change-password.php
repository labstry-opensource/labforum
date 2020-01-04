<?php
//Temp classes

if(!isset($_POST['id']) || !isset($_POST['password'])){
    return false;
}

include dirname(__FILE__) . '/../classes/connect.php';
include dirname(__FILE__) . '/../classes/Users.php';

$users = new Users($pdoconnect, '');

$id = @$_POST['id'];
$password = @$_POST['password'];

$users->setPassword($id, $password);
