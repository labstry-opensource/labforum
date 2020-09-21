<?php

if(!isset($_SESSION)) session_start();

include_once dirname(__FILE__) . '/../autoload.php';

$userroles = new UserRoles($pdoconnect);
$essential = new Essentials($pdoconnect);

$role_arr = $userroles->getUserRole(@$_SESSION['id']);
$right = $role_arr['rights'];

$essential->imposeRestrictAccess($right, 90);

include_once dirname(__FILE__) . '/view/page-user-manage.php';
?>
