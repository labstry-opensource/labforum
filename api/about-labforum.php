<?php

include dirname(__FILE__) . '/../autoload.php';

$updater = new LabforumUpdater($pdoconnect);

if(@$_GET['check'] === 'update'){
    header('Content-Type: application/json');
    echo json_encode($updater->checkUpdate());
    exit;
}

header('Content-Type: application/json');

$data = array();
$data['version'] = $updater->getCurrentVersion();

print_r(json_encode($data['version']));