<?php

defined('LAF_PATH') || define('LAF_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
defined('LAF_ROOT_PATH') || define('LAF_ROOT_PATH', dirname(__FILE__));
defined('DIR') || define('DIR', dirname(__DIR__));
defined('API_PATH') || define('API_PATH', LAF_ROOT_PATH . '/api');
defined('BASE_URL') || define('BASE_URL', str_replace($_SERVER['DOCUMENT_ROOT'], '', LAF_PATH));
defined('BASE_ROOT_URL') || define('BASE_ROOT_URL', str_replace(DIR, '', LAF_ROOT_PATH));
defined('BASE_ROOT_API_URL') || define('BASE_ROOT_API_URL', BASE_ROOT_URL . '/api');


defined('LANGUAGE') || define('LANGUAGE', ':language');
defined('DATABASE') || define('DATABASE', ':database');
defined('DB_SERVER') || define('DB_SERVER',  ':serveraddr');
defined('DB_USERNAME') || define('DB_USERNAME',  ':username');
defined('DB_PASSWORD') || define('DB_PASSWORD',  ':password');
defined('DB_TYPE') || define('DE_TYPE', ':db_type');

if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    defined('PROTOCOL') || define('PROTOCOL', 'https://');
}else {
    defined('PROTOCOL') || define('PROTOCOL', 'http://');
}

