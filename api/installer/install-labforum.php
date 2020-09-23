<?php

//We can't depend on laf-config here as it has supposed not been initialised AT THIS POINT.
//WARNING: DON'T EXECUTE THIS CODE CROSS DOMAIN. OTHERWISE SQL INJECTION WILL HAPPENS.

include dirname(__FILE__) . '/../../src/APITools.php';
include dirname(__FILE__) . '/../../vendor/autoload.php';

//Setting up SESSION
$_SESSION['username'] = 'LabforumInstaller';
session_start();

$supported_db = array('mysql', 'mssql', 'oracle');

$apitools = new APITools();
$install_validator = new Validators\InstallerValidator($_POST);
$data['error'] = $install_validator->validate();


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
    array(':language', ':database', ':serveraddr', ':username', ':password', ':db_type'),
    array($_POST['language'], $_POST['dbname'] , $_POST['serveraddr'], $_POST['username'], $_POST['password'], $_POST['db_type']),
    $laf_config_template);

$port_replace = (!empty($_POST['db_port'])) ? $_POST['db_port'] : '';
$laf_config_template = str_replace("'port';" , (empty($port_replace) ? '' :
    "defined('DB_PORT') || define('DE_PORT', '" . $_POST['db_port'] ."');"),
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

//Sorry. We can't create database using Medoo. We have to create it our own, using PDO before it is available.
switch ($_POST['db_type']){
    case 'mysql':
    case 'mariadb':
        $connection = new PDO("mysql:host=$host;charset=utf8", $username, $password);
        break;

    case 'mssql':
        $connection = new PDO("sqlsrv:Server=$host;", $username, $password);



}

if($_POST['db_type'] === 'mysql' || $_POST['db_type'] === 'mariadb')
{

}
else if($_POST['db_type'] == 'mssql')
{

}
else if($_POST[''])



try{
    //Check if user has right in creating a database.
    $rand = rand(10000, 99999);
    //fallback for PHP prior to 5.3.6
    $connection->pdo("CREATE DATABASE #test$rand");
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
