<?php
if(!isset($_SESSION)) session_start();

include_once dirname(__FILE__ ) . '/../autoload.php';

$userroles = new UserRoles($connection);
$essential = new Essentials($pdoconnect);
$roles_arr = $userroles->getUserRole(@$_SESSION['id']);
$right = $roles_arr['rights'];

$essential->imposeRestrictAccess($right, 90);

include dirname(__FILE__ ) . '/view/page-forum.php';