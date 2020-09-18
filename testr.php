<?php
header('Content-Type: application/json; charset=utf-8');
include dirname(__FILE__) . '/autoload.php';

$users = new Users($connection);

$page = empty($_GET['page']) ? 0 : $_GET['page'];
$page_count = empty($_GET['count']) ? 10 : $_GET['count'];

print_r(json_encode($users->searchUsername('', 'username', $page, $page_count)));

?>