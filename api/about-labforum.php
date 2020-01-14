<?php

include dirname(__FILE__) . '/classes/connect.php';
include dirname(__FILE__) . '/classes/LabforumUpdater.php';

$updater = new LabforumUpdater($pdoconnect);

header('Content-Type: application/json');
print_r(json_encode($updater->getCurrentVersion()));