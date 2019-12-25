<?php

include "classes/connect.php";
include "classes/Thread.php";

header('Content-Type: application/json; charset=utf-8');

$id = @$_GET['id'];
$thread = new Thread($pdoconnect);

echo $thread->getDescription($id);