<?php

include_once dirname(__FILE__) . '/../autoload.php';
if(!isset($_SESSION)) session_start();

$apitools = new APITools();


if(isset($_SESSION['username']) || isset($_SESSION['id'])){
    session_destroy();
    $data['sucess'] = true;
    $apitools->outputContent($data);
    exit;
}else{
    $data = array(
        'error' => 'Not logged in.',
    );
    $apitools->outputContent($data);
}