<?php
require_once dirname(__FILE__) . '/laf-config.php';
require_once(dirname(__FILE__).'/classes/connect.php');
include_once(dirname(__FILE__) . '/maintenance.php');
include_once(dirname(__FILE__)."/classes/Users.php");
include_once(dirname(__FILE__).'/classes/UserRoles.php');
include_once(dirname(__FILE__).'/classes/Sign.php');
include_once (dirname(__FILE__) . "/classes/Essentials.php");

include "views/page-forum-unstable.php";
?>