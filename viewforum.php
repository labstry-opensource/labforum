<?php

require_once dirname(__FILE__) . '/laf-config.php';
require_once LAF_PATH . "/classes/connect.php";
require_once LAF_PATH . "/classes/UserRoles.php";
require_once LAF_PATH . "/classes/Forum.php";
include_once dirname(__FILE__) . "/classes/Essentials.php";


$roles = new UserRoles($pdoconnect);
$roles->getUserRole(@$_SESSION['id']);

if($roles->rights >= 90){
    include LAF_PATH . '/views/page-forum-unstable.php';
}else{
    include LAF_PATH . '/views/page-forum-stable.php';
}
