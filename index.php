<?php 
require_once(dirname(__FILE__).'/classes/connect.php');
require_once(dirname(__FILE__).'/ranking.php');
include_once(dirname(__FILE__).'/classes/HeaderGenerator.php');
include_once(dirname(__FILE__).'/maintenance.php');
include_once(dirname(__FILE__)."/classes/Users.php");
include_once(dirname(__FILE__).'/classes/UserRoles.php');
include_once(dirname(__FILE__).'/classes/Sign.php');
include_once (dirname(__FILE__) . "/classes/Essentials.php");



$roles = new UserRoles($pdoconnect);
$roles->getUserRole(@$_SESSION['id']);

if($roles->rights >= 90){
    include_once dirname(__FILE__) . '/views/page-index-unstable.php';
}else{
    include_once dirname(__FILE__) . '/views/page-index-stable.php';
}


?>
