<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include_once  dirname(__FILE__)."/classes/connect.php";
include_once  dirname(__FILE__)."/classes/Users.php";
require_once  dirname(__FILE__)."/classes/Forum.php";
include_once  dirname(__FILE__).'/classes/UserRoles.php';
include_once dirname(__FILE__) . '/maintenance.php';
include_once  dirname(__FILE__) . "/classes/Essentials.php";

$roles = new UserRoles($pdoconnect);
$roles->getUserRole(@$_SESSION['id']);


if($roles->rights < 89){
    include dirname(__FILE__) . '/views/page-forumlist-stable.php';

}else{

    include dirname(__FILE__) . '/views/page-forumlist-unstable.php';
}