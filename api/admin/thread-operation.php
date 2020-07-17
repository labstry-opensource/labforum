<?php
if(!isset($_SESSION)) session_start();

include dirname(__FILE__) . '/../../autoload.php';


$msg = include LAF_ROOT_PATH .'/locale/' . LANGUAGE . '/admin/api-thread-operation.php';

$apitools = new APITools();
$user_role = new UserRoles($pdoconnect);

//Integrity check

if(!isset($_SESSION['id'])){
    $data['error'] = $msg['not-logged-in'];
    $apitools->outputContent($data);
}

if(empty($_POST)){
    $data['error'] = $msg['nothing-posted'];
    $apitools->outputContent($data);
}
if(!isset($_POST['thread_id'])){
    $data['error']['thread_id'] = $msg['thread-not-specified'];
    $apitools->outputContent($data);
}

$user_role_arr = $user_role->getUserRole($_SESSION['id']);
$rights = $user_role_arr['rights'];

$apitools->imposeRightRestriction(90, $rights);

if(empty($_POST['password']) || ($_POST['password'] !== $_POST['repassword'])){
    $data['error']['repassword'] = $msg['incorrect-password-validate'];
    $apitools->outputContent($data);
}

$users = new Users($pdoconnect);
if(!$users->validatePassword($_SESSION['id'], $_POST['password'])){
    $data['error']['repassword'] = $msg['password-incorrect'];
    $apitools->outputContent($data);
}

if(!isset($_POST['action'])){
    $data['error'] = $msg['no-action-specified'];
    $apitools->outputContent($data);
}

//Handle thread operation
if($_POST['action'] === 'promote' || $_POST['action'] === 'demote'){
    if(!isset($_POST['level'])){
        $data['error']['level'] = $msg['promote-level-not-specified'];
        $apitools->outputContent($data);
    }
    $operation = new ThreadOperation($pdoconnect);
    switch ($_POST['level']){
        case '1':
            if($user_role_arr['rights'] < 91){
                $data['error']['level'] = $msg['insufficient-right-promote-home'];
                $apitools->outputContent($data);
            }
            $operation->setShowInIndex($_POST['thread_id']);
            break;
        case '2':
            $operation->promoteThread($_POST['thread_id']);
            $operation->withdrawnFromIndex($_POST['thread_id']);
            break;
        case '3':
            $operation->demoteThread($_POST['thread_id']);
            $operation->withdrawnFromIndex($_POST['thread_id']);
    }
    $data['success'] = $msg['success-promote-demote'];
    $apitools->outputContent($data);

}else if($_POST['action'] === 'hidden'){
    $operation = new ThreadOperation($pdoconnect);
    $operation->setHiddeni($_POST['thread_id']);

}else if($_POST['action'] === 'property_change'){
    $thread = new Thread($pdoconnect);
    $operation = new ThreadOperation($pdoconnect);
    $forum = new Forum($pdoconnect);
    if(!$thread->checkHasSuchThread($_POST['thread_id'])){
        $data['error']['fid'] = $msg['thread-not-exists'];
        $apitools->outputContent($data);
    }
    $thread_arr = $thread->getThreadProp($_POST['thread_id']);
    if($thread_arr['fid'] !== $_POST['fid']){
        if(!$forum->checkHasForum($_POST['fid'])){
            $data['error']['fid'] = $msg['forum-not-exists'];
            $apitools->outputContent($data);
        }
        $operation->moveThreadToForum( $_POST['thread_id'], $_POST['fid']);
    }
    if(!empty($_POST['highlight'])){
        if(!(ctype_xdigit(substr($_POST['highlight'],1)) ||
            strlen(ltrim($_POST['highlight'],"#"))==8)){
            $data['error']['highlight'] = $msg['colour-not-valid'];
            $apitools->outputContent($data);
        }
        $operation->setHighLightColor($_POST['thread_id'], $_POST['highlight']);
    }
}