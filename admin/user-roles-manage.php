<?php

if (!isset($_SESSION)) session_start();

include_once dirname(__FILE__) . '/../laf-config.php';
include_once dirname(__FILE__) . '/../classes/connect.php';
include_once dirname(__FILE__) . '/../classes/UserRoles.php';
include_once dirname(__FILE__) . '/../classes/Essentials.php';

$userroles = new UserRoles($pdoconnect);
$essential = new Essentials($pdoconnect);

$userroles->getUserRole(@$_SESSION['id']);
$right = $userroles->rights;

$essential->imposeRestrictAccess($right, 0);

include dirname(__FILE__) . '/view/page-roles-manage.php';