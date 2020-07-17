<?php
if(!isset($_SESSION)) session_start();

include_once dirname(__FILE__ ) . '/../autoload.php';

$userroles = new UserRoles($pdoconnect);
$essential = new Essentials($pdoconnect);
$userroles->getUserRole(@$_SESSION['id']);
$right = $userroles->rights;

$essential->imposeRestrictAccess($right, 90);

include dirname(__FILE__ ) . '/view/page-forum.php';