<?php

include dirname(__FILE__) . '/../../autoload.php';
include LAF_ROOT_PATH . '/../../src/Maintenance.php';

$maintenance = new Maintenance($connection);
$maintenance->setMaintenance();
