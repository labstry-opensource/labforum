<?php
session_start();
include dirname(__FILE__) . '/classes/connect.php';
include dirname(__FILE__) . '/classes/Forum.php';
include dirname(__FILE__) . '/classes/UserRoles.php';

$userid = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

$forum = new Forum($pdoconnect);
$roles = new UserRoles($pdoconnect);

$user_role = $roles->getUserRole($userid);

$forum_arr = array();
$board_ids = $forum->getForumListId();



foreach($board_ids as $board_id){
    $board_arr = array();
    $board_arr['board_id'] = $board_id;
    $board_arr['board_name'] = $forum->getForumName($board_id);
    $sub_forum_list = $forum->getSubforums($board_id);
    foreach($sub_forum_list as $forum_list_arr){
        if($forum->hasRightsToViewForum($forum_list_arr['fid'], $user_role['rights'])){
            $board_arr['forum'] = $forum_list_arr;
        }
        array_push($forum_arr, $board_arr);
    }

}
header('Content-Type: application/json; charset=utf-8');
print_r(json_encode($forum_arr));



