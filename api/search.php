<?php

include_once dirname(__FILE__) . '/../autoload.php';

$apitools = new APITools();

if(!isset($_GET['keyword'])){
    $apitools->outputContent(''); exit;
}

$thread = new Thread($pdoconnect);
$search_thread['data'] = $thread->searchThreadByName($_GET['keyword']);

$apitools->outputContent($search_thread);