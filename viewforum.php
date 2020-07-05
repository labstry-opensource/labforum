<?php

include_once dirname(__FILE__) . '/autoload.php';

if(!isset($_SESSION)) session_start();

$roles = new UserRoles($pdoconnect);
$roles_arr = $roles->getUserRole(@$_SESSION['id']);

$forum = new Forum($pdoconnect);

if(!$forum->hasRightsToViewForum($_GET['id'], $roles_arr['rights'])){
    http_response_code(403);
    $error_arr = array(
        'error_info' => 'INSUFFICIENT_RIGHTS',
        'error_msg' => 'you have no rights to view this forum',
        'link' => array(
            array(
                'title' => 'Back to home',
                'href' => BASE_URL. '/index.php',
            ),
            array(
                'title' => 'Try logging in to see if the problem solved.',
                'href' => BASE_URL. '/../login.php',
            )
        )
    );
    include LAF_PATH . '/error_page/general-error.php';
    die;
}

include LAF_PATH . '/views/page-forum-unstable.php';
