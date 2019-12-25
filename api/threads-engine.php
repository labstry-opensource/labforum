<?php
error_reporting(E_ALL); ini_set('display_errors',1);
include "classes/connect.php";
include "classes/Thread.php";
include "classes/ThreadProp.php";


$id = @$_GET['id'];

header('Content-Type: application/json; charset=utf-8');

$thread = new Thread($pdoconnect);

$resultarr = $thread->getThreadProp($id);
//Get reply count
$resultarr['reply_count'] = $thread->numberOfReplies($id);
$resultarr['replies'] = array();

if((!@$_GET['reply_from'])||(!@$_GET['reply_to'])) {
	$reply_from = 1;
	$reply_to = $resultarr['reply_count'];
}else{
	$reply_from = @$_GET['reply_from'];
	$reply_to = @$_GET['reply_to'];
}


for($i = $reply_from; $i <= $reply_to; $i++){
	if($i > $resultarr["reply_count"]) break;
	$replyprop = new ReplyProp($pdoconnect, '', $id, $i);
	array_push($resultarr['replies'], $replyprop->getThreadProp());
}


echo json_encode($resultarr);

?>
