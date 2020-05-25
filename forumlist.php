<?php
include_once dirname(__FILE__) . '/autoload.php';
include_once LAF_PATH . '/src/connect.php';

$roles = new UserRoles($pdoconnect);
$roles->getUserRole(@$_SESSION['id']);

include dirname(__FILE__) . '/views/page-forumlist-stable.php';