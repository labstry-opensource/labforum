<?php
require_once dirname(__FILE__) . '/laf-config.php';
include_once LAF_ROOT_PATH . '/src/connect.php';
include_once LAF_ROOT_PATH . '/functions.php';

if(!isset($_SESSION)){
    session_start();
}

function autoload($class){
    include LAF_ROOT_PATH . "/src/{$class}.php";
}

spl_autoload_register('autoload');

function errHandle($errNo, $errStr, $errFile, $errLine) {
    if (error_reporting() == 0) {
        // @ suppression used, don't worry about it
        return;
    }
    $msg = "$errStr in $errFile on line $errLine";
    if ($errNo == E_NOTICE || $errNo == E_WARNING) {
        throw new ErrorException($msg, $errNo);
    } else {
        echo $msg;
    }
}

set_error_handler('errHandle');
