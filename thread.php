<?php
require_once dirname(__FILE__). '/laf-config.php';
include_once dirname(__FILE__)."/api/classes/connect.php";
include_once dirname(__FILE__)."/classes/Users.php";
include_once dirname(__FILE__)."/classes/Essentials.php";
include_once dirname(__FILE__)."/api/classes/UserRoles.php";
include_once dirname(__FILE__)."/classes/AuthorProp.php";
include_once dirname(__FILE__)."/classes/ThreadProp.php";
include_once dirname(__FILE__)."/api/classes/Thread.php";

if(!isset($_SESSION)) session_start();

$roles = new UserRoles($pdoconnect);
$roles_arr = $roles->getUserRole(@$_SESSION['id']);


$thread = new Thread($pdoconnect);
if(!isset($_GET['id']) || !$thread->checkHasSuchThread($_GET['id'])){
    $error_arr = array(
        'error_info' => 'NO_SUCH_THREAD',
        'error_msg' => 'show 唔到你想睇的帖子',
        'link' => array(
            array(
                'title' => '返回首頁',
                'href' => BASE_URL. '/index.php',
            )
        )
    );
}else if(!$thread->checkHasRightToViewThisThread($_GET['id'], $roles_arr['rights'])){
    http_response_code(404);
    $error_arr = array(
        'error_info' => 'INSUFFICIENT_RIGHTS',
        'error_msg' => 'show 唔到你想睇的帖子',
        'link' => array(
            array(
                'title' => '返回首頁',
                'href' => BASE_URL. '/index.php',
            ),
            array(
                'title' => '嘗試登入，看能不能解決問題',
                'href' => BASE_URL. '/../login.php',
            )
        )
    );
}

if(isset($error_arr)){
    include LAF_PATH . '/error_page/general-error.php';
    die;
}


include_once 'views/page-thread-stable.php';


?>