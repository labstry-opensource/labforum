<?php

include_once dirname(__FILE__) . '/autoload.php';
include_once LAF_ROOT_PATH . '/src/connect.php';


$roles = new UserRoles($connection);
$roles_arr = $roles->getUserRole(@$_SESSION['id']);


include_once dirname(__FILE__) . '/views/page-index-stable.php';


?>
