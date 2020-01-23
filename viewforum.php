<?php
require_once dirname(__FILE__) . '/laf-config.php';
include_once dirname(__FILE__) . "/classes/connect.php";
include_once dirname(__FILE__) . "/classes/Essentials.php";
include_once dirname(__FILE__) . '/maintenance.php';
include_once dirname(__FILE__) . "/classes/Users.php";
include_once dirname(__FILE__) . '/classes/UserRoles.php';
include_once dirname(__FILE__) . "/classes/Essentials.php";
include_once dirname(__FILE__) . "/classes/Forum.php";
include_once dirname(__FILE__) . '/classes/Moderator.php';
include_once dirname(__FILE__) . "/classes/RedirectToolkit.php";


$roles = new UserRoles($pdoconnect);
$roles->getUserRole(@$_SESSION['id']);


if($roles->rights >= 90){
    include LAF_PATH . '/views/page-forum-unstable.php';
}else{
    include LAF_PATH . '/views/page-forum-stable.php';
}
