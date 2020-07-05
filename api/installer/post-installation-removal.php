<?php

include dirname(__FILE__) . '/../../autoload.php';

if(!isset($_GET['keep_files'])){
    //These files can be removed after installation
    $unlink_files = array(
        API_PATH . '/installer/install-labforum.php',
        API_PATH . '/installer/post-installation-removal.php',
        LAF_ROOT_PATH . '/labforum-installer.php',
        LAF_ROOT_PATH . '/laf-config-template.php',
    );

    foreach($unlink_files as $file){
        unlink($file);
    }
}

$data['success'] = true;

$apitools = new APITools();
$apitools->outputContent($data);