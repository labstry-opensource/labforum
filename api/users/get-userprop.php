<?php

include_once dirname(__FILE__) . '/../../autoload.php';

$apitools = new APITools();
$users = new Users($connection);

if(!isset($_GET['userid'])){
    $data['data']['error'] = 'No username is defined';
    $apitools->outputContent($data);
}

if(empty($users->getUserPropById($_GET['id']))){
    $data['data']['error'] = 'No such user';
    $apitools->outputContent($data);
}

$data['data'] = $users->getUserPropById($_GET['userid']);

$apitools->outputContent($data);