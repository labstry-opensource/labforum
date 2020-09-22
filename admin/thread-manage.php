<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
if(!isset($_SESSION)) session_start();

include_once dirname(__FILE__ ) . '/../autoload.php';

$userroles = new UserRoles($pdoconnect);
$essential = new Essentials($pdoconnect);
$roles_arr = $userroles->getUserRole(@$_SESSION['id']);

$essential->imposeRestrictAccess($roles_arr['rights'], 90);

$threadid =  @$_GET['id'];
$thread = new Thread($pdoconnect);
$thread_arr = $thread->getThreadProp($threadid);


$forum = new Forum($connection);

$forum_arr = array();
$board_ids = $forum->getForumListId();

foreach($board_ids as $board_id) {
    $sub_forum_list = $forum->getSubforums($board_id);
    foreach($sub_forum_list as $forum_list_arr){
        $forum_arr_arr['fid'] = $forum_list_arr['fid'];
        $forum_arr_arr['fname'] = $forum_list_arr['fname'];
        array_push($forum_arr, $forum_arr_arr);
    }

}

if(!$forum->isModerator($thread_arr['fid'], $_SESSION['id']) &&
    $roles_arr['rights'] < 90){
    include LAF_PATH . '/../error_page/not-a-moderator.php';
    die;
}
include LAF_PATH . '/view/page-thread-manage.php';
?>

