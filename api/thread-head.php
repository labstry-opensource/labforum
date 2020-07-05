<?php
include dirname(__FILE__) . '/../autoload.php';

$apitools = new APITools($pdoconnect);

if(!isset($_GET['id'])){
    $data['error'] = 'No thread ID is specified';
    $apitools->outputContent($data);
}

$id = $_GET['id'];
$thread = new Thread($pdoconnect);

echo $thread->getDescription($id);