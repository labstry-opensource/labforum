<?php
if(!isset($_SESSION)) session_start();

include dirname(__FILE__) . '/../../autoload.php';


$apitools = new APITools();
$user_role = new UserRoles($pdoconnect);

if(!isset($_SESSION['id'])){
    $data['error'] = 'Pleas login to continue';
    $apitools->outputContent($data);
}

$role_arr = $user_role->getUserRole($_SESSION['id']);
$rights = $role_arr['rights'];

$apitools->imposeRightRestriction(90, $rights);

$data['data'] = $user_role->showManagingBoard($_SESSION['id']);

$apitools->outputContent($data);
