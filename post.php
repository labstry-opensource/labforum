<?php

include_once dirname(__FILE__) . '/autoload.php';

if(!isset($_SESSION)) session_start();


if(!isset($_SESSION['id'])){
    http_response_code(403);
    $error_arr = array(
        'error_info' => 'INSUFFICIENT_RIGHTS',
        'error_msg' => '你不能編輯此帖子',
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
    include LAF_PATH . '/error_page/general-error.php';
    die;
}

$thread = new Thread($pdoconnect);
$validator = new ThreadValidator($pdoconnect, null);
$roles = new UserRoles($connection);
$roles_arr = $roles->getUserRole(@$_SESSION['id']);


if(isset($_GET['id'])){
    if(!$thread->checkHasSuchThread($_GET['id'])){
        http_response_code(403);
        $errormsg = "NO_SUCH_THREAD";
        include LAF_PATH . '/error_page/not_allowed_to_edit.php';
        die;
    }
    if(!$thread->isThreadAuthor($_GET['id'], $_SESSION['id']) && !$roles_arr['rights'] > 90){
        http_response_code(403);
        $error_arr = array(
            'error_info' => 'INSUFFICIENT_RIGHTS',
            'error_msg' => '你不能編輯此帖子',
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
        include LAF_PATH . '/error_page/general-error.php';
        die;
    }
}


include dirname(__FILE__) . '/views/page-post-unstable.php';