<?php
include_once dirname(__FILE__) . '/autoload.php';

$roles = new UserRoles($connection);
$roles->getUserRole(@$_SESSION['id']);

include dirname(__FILE__) . '/views/page-forumlist-stable.php';