<?php

if (!isset($_SESSION)) session_start();

include_once dirname(__FILE__) . '/../autoload.php';

$userroles = new UserRoles($connection);
$essential = new Essentials($pdoconnect);

$userroles->getUserRole(@$_SESSION['id']);
$right = $userroles->rights;

$essential->imposeRestrictAccess($right, 0);

include dirname(__FILE__) . '/view/page-roles-manage.php';