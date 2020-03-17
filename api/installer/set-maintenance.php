<?php

include dirname(__FILE__) . '/../classes/APITools.php';
include API_PATH . '/classes/Maintenance.php';

$maintenance = new Maintenance($pdoconnect);
$maintenance->setMaintenance();
