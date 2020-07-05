<?php

//We can't depend on laf-config here as it has supposed not been initialised AT THIS POINT.
//WARNING: DON'T EXECUTE THIS CODE CROSS DOMAIN. OTHERWISE SQL INJECTION WILL HAPPENS.

include dirname(__FILE__) . '/../classes/APITools.php';

//Setting up SESSION
$_SESSION['username'] = 'LabforumInstaller';
session_start();

$apitools = new APITools();

if(empty($_POST['username'])){
    $data['error']['username'] = 'Username can\'t be empty';
}
if(empty($_POST['superuser'])){
    $data['error']['superuser'] = 'Username can\'t be empty';
}
if(empty($_POST['password'])){
    $data['error']['password'] = 'Password can\'t be empty';
}
if(empty($_POST['superuserpassword'])){
    $data['error']['superuserpassword'] = 'Password can\'t be empty';
}
if(empty($_POST['dbname'])){
    $data['error']['dbname'] = 'Please choose a database name. A name that can be known only to you.';
}else if(!preg_match('/^[0-9a-zA-Z$_]+$/', $_POST['dbname'])){
    $data['error']['dbname'] = 'Only digits from 0-9, a-z or A-Z alphabets, $ and _ are allowed for database name. Lower cases are recommended.';
}

if(!empty($data['error'])){
    $apitools->outputContent($data);
}

$host = empty($_POST['serveraddr'])?  '127.0.0.1' : $_POST['serveraddr'];
$username = $_POST['username'];
$password = $_POST['password'];
$template_file = dirname(__FILE__) . '/../../laf-config-template.php';
$target_file = dirname(__FILE__) . '/../../laf-config.php';

//Replace placeholders from the template

$laf_config_template = file_get_contents($template_file);
$laf_config_template = str_replace(
    array(':language', ':database', ':serveraddr', ':username', ':password'),
    array($_POST['language'], $_POST['dbname'] , $_POST['serveraddr'], $_POST['username'], $_POST['password']),
    $laf_config_template);

if(!is_writable(dirname($target_file))){
    $data = array(
        'msg' => 'Your directory ' . dirname($target_file) . ' is not writable. Please install your config file manually',
        'error' => true,
    );
    $apitools->outputContent($data);
}

//No matter what, we delete the laf-config files and create a new one if it exists.
if(file_exists($target_file)){
    unlink($target_file);
}

$laf_config_pointer = fopen($target_file, 'w');
fwrite($laf_config_pointer, $laf_config_template);
fclose($laf_config_pointer);

if(!file_exists($target_file)){
    $data = array(
        'msg' => 'Unknown error occured. Check whether your laf-config.php exists in directory ' . dirname($target_file) ,
        'error' => true,
    );

}


//LAF CONFIG is ready.
include $target_file;

$connect = new PDO("mysql:host=" .DB_SERVER .";charset=utf8mb4", $_POST['superuser'] , $_POST['superuserpassword'],  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

try{
    //Check if user has right in creating a database.
    $rand = rand(10000, 99999);
    //fallback for PHP prior to 5.3.6
    $connect->exec("SET names utf8mb4");
    $connect->exec('CREATE DATABASE `#test'. $rand.'`');
    $connect->exec('DROP DATABASE `#test' . $rand . '`');
}catch(PDOException $e){
    $data['error']['superuser'] = 'You have no rights in creating a database, try using a different username';
    $apitools->outputContent($data);
}

try{
    if(isset($_POST['delete_db_when_exists'])){
        $connect->exec('DROP DATABASE IF EXISTS `'. $_POST['dbname'] .'`');
    }
    $connect->exec('CREATE DATABASE `'. $_POST['dbname'] .'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');

    $connect->exec('USE `'. $_POST['dbname']. '`');
    $connect->exec('GRANT SELECT, CREATE, INSERT, UPDATE, DELETE, ALTER, DROP on 
        `'. $_POST['dbname'].'`.* TO \''. $_POST['username'].'\'@\'%\'');


}catch(PDOException $e){
    print_r($e->getMessage());
    if($e->errorInfo[1] === 1007){
        $data['error']['dbname'] = 'The database is already exists. Cannot create a new database named ' . $_POST['dbname']. '.';
        $apitools->outputContent($data);
    }
}

$data['success'] = true;

$apitools->outputContent($data);
