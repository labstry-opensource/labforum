<?php

include_once dirname(__FILE__) . '/autoload.php';
include_once LAF_ROOT_PATH . '/src/Connect.php';


$roles = new UserRoles($connection);
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
$roles_arr = $roles->getUserRole($user_id);


include_once dirname(__FILE__) . '/views/page-index-stable.php';


?>
