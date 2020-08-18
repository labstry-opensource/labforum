<?php
if(!isset($_SESSION)) session_start();

include dirname(__FILE__) . '/';

include dirname(__FILE__) . '/../../laf-config.php';
include dirname(__FILE__) . '/classes/connect.php';
include dirname(__FILE__) . '/../classes/APITools.php';
include dirname(__FILE__) . '/../classes/UserRoles.php';

$apitools = new APITools();
$user_role = new UserRoles($pdoconnect);

if(!isset($_SESSION['id'])){
    $data['error'] = 'Pleas login to continue';
    $apitools->outputContent($data);
}

$data = $user_role->getUserRole($_SESSION['id']);
$rights = $data['rights'];

$apitools->imposeRightRestriction(90, $rights);

$data = $user_role->showManagingBoard($_SESSION['id']);

$apitools->outputContent($data);
