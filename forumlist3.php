<?php
require_once dirname(__FILE__). '/laf-config.php';
include_once  dirname(__FILE__)."/classes/connect.php";
include_once  dirname(__FILE__)."/classes/Users.php";
require_once  dirname(__FILE__)."/classes/Forum.php";
include_once  dirname(__FILE__).'/classes/UserRoles.php';
include_once dirname(__FILE__) . '/maintenance.php';
include_once  dirname(__FILE__) . "/classes/Essentials.php";

$roles = new UserRoles($pdoconnect);
$roles->getUserRole(@$_SESSION['id']);

include dirname(__FILE__) . '/views/page-forumlist-unstable.php';