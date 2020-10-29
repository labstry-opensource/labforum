<?php

include_once dirname(__FILE__) . '/autoload.php';

$users = new Users($connection);
if(!empty($_GET['id']) || empty($users->getUserPropById($_GET['id']))){
    http_response_code(404);
    include_once LAF_ROOT_PATH . '/error_page/no_such_thread.php';
    exit;
}

$username = $users->getUsernameById($_GET['id']);

include dirname(__FILE__) . '/views/page-profile.php';
