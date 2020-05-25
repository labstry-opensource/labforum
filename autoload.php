<?php
require_once dirname(__FILE__) . '/laf-config.php';

if(!isset($_SESSION)){
    session_start();
}

function autoload($class){
    include LAF_PATH . '/src/' . $class . '.php';
}

spl_autoload_register('autoload');