<?php


defined('LAF_PATH') || define('LAF_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
defined('BASE_URL') || define('BASE_URL', str_replace($_SERVER['DOCUMENT_ROOT'], '', LAF_PATH));
defined('DIR') || define('DIR', defined('ABSPATH') ? 'template' : basename(dirname(dirname(dirname(__FILE__)))));



defined('DB_SERVER') || define('DB_SERVER',  'localhost');
defined('DB_USERNAME') || define('DB_USERNAME',  'playground');
defined('DB_PASSWORD') || define('DB_PASSWORD',  'plyg2043');


if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    define('PROTOCOL', 'https://');
}else {
    define('PROTOCOL', 'http://');
}