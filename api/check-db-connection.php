<?php

//Please define the configurations here. We have got no laf-config files.
defined('LAF_PATH') || define('LAF_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
defined('INSTALL_API_ROOT_PATH') || define('INSTALL_API_ROOT_PATH', dirname(__FILE__));
include INSTALL_API_ROOT_PATH . "../src/APITools.php";

$apitools = new APITools();
$lang = (isset($_GET['lang']) && checkTranslationExists($_GET['lang'], '/api/api-check-db-connection.php')) ? $_GET['lang'] : 'en';

loadTranslation();


//This is an api for checking whether the db connection is functional
$host = empty($_POST['serveraddr'])?  '127.0.0.1' : $_POST['serveraddr'];

if(empty($_POST['username'])){
    $data['error']['username'] = 'Username can\'t be empty';
}
if(empty($_POST['password'])){
    $data['error']['password'] = 'Password can\'t be empty';
}

if(!empty($data['error'])){
    $apitools->outputContent($data);
}

$username = $_POST['username'];
$password = $_POST['password'];

try{
    $connect_test = new PDO("mysql:host=$host",
        $username,
        $password,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    $data['success'] = 'The database connection is functional';

}catch(PDOException $e){
    $error_code = $e->getCode();
    $data = array();
    switch ($error_code){
        case '1045':
            $data['error']['password'] = 'The username or password for the mysql database is incorrect';
            break;
        case '2002':
            $data['error']['serveraddr'] = 'No such address. Please check your address.';
            break;
    }
    $apitools->outputContent($data);
}


