<?php
session_start();

header('Content-Type: application/json');
$data = array();

//Redirect users away
if(!@$_SESSION["id"]){
	$data["error"] = "Not logged in.<a href=\"/login.php\">Log In</a>";
	echo json_encode($data);
	exit;
}

include_once "classes/AddReply.php";
include_once "classes/connect.php";


//Initialise toolkits
$addreply = new AddReply($pdoconnect, "", $id);
$tid = @$_SESSION["id"];

$reply_title = @$_POST["reply-title"];
$reply_content = @$_POST["reply_content"];
$addreply->submitReply($reply_title, $reply_content);

$data["success"] = "true";
echo json_encode($data);


?>