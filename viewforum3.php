<?php
require_once dirname(__FILE__) . '/laf-config.php';
require_once dirname(__FILE__) .'/classes/connect.php';
include_once dirname(__FILE__) . '/maintenance.php';
include_once dirname(__FILE__)."/classes/Users.php";
include_once dirname(__FILE__).'/classes/UserRoles.php';
include_once dirname(__FILE__) . "/classes/Essentials.php";
include_once dirname(__FILE__) . "/classes/Forum.php";
include_once dirname(__FILE__) . '/classes/Moderator.php';
include_once dirname(__FILE__) . "/classes/RedirectToolkit.php";

$forum = new Forum($pdoconnect);
$toolkit = new RedirectToolkit();
$fid = @$_GET['id'];

if(!isset($fid) || !$forum->getSubforumName($fid)){
    echo $forum->getSubforumName($fid);
    $toolkit->set404();
}

include "views/page-forum-unstable.php";
?>
