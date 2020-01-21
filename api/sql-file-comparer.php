<?php


include dirname(__FILE__) . '/classes/SQLComparer.php';

$db_username = @$_GET['username'];
$db_password = @$_GET['password'];
$hostname = 'localhost';

if(!$db_username || !$db_password){
    $data['error'] = 'No username or password';
    print_r(json_encode($data));
    die;
}

$adminconnect = new PDO('mysql:host='. $hostname .';', $db_username, $db_password);


$old_sql = file_get_contents(dirname(__FILE__) . '/updates/forum_db_old.sql');
$new_sql = file_get_contents(dirname(__FILE__) . '/updates/forum_db_new.sql');

$comparer = new SQLComparer($adminconnect, $old_sql, $new_sql);

$sql_diff = $comparer->getStructureChange();

print_r($sql_diff); exit;


