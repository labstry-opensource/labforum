<?php
//Temp classes
include dirname(__FILE__) . '/../../autoload.php';

$apitools = new APITools();

if(!isset($_SESSION['id'])){
    $data['data']['error'] = 'Please login before continue';
}
if(!isset($_POST['id'])){
    $data['data']['error'] = 'Please specify a userid';
}
if(!isset($_POST['password'])){
    $data['data']['error'] = 'Please specify a password to be changed';
}


$userroles = new UserRoles($pdoconnect);
$roles = $userroles->getUserRole($_SESSION['id']);

if($roles['rights'] <  90){
    $data['data']['error'] = 'Please login before continue';
}


$users = new Users($connection);

if(!$users->getUserPropById($userid)){

}

if(!empty($data)){
    $apitools->outputContent($data);
}


$id = @$_POST['id'];
$password = @$_POST['password'];

$users->setPassword($id, $password);
