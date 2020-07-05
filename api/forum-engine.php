<?php
include_once dirname(__FILE__) . '/../autoload.php';

$userid = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

$forum = new Forum($pdoconnect);
$roles = new UserRoles($pdoconnect);
$api_tools = new APITools();


$user_role = $roles->getUserRole($userid);

if(isset($_GET['fid'])){
    $fid = $_GET['fid'];
    if(empty($forum_arr = $forum->getSubformByFid($fid))){
        $data['error'] = 'No such forum';
        $api_tools->outputContent($data);
    }
    $forum_data['moderators'] = $forum->getModerators($fid);
    $forum_data['fid'] = $forum_arr['fid'];
    $forum_data['fname'] = $forum_arr['fname'];
    $forum_data['rules'] = $forum_arr['rules'];
    $forum_data['forum_banner'] = $forum_arr['forum_banner'];

    $api_tools->outputContent($forum_data);
}else{
    $forum_arr = array();
    $board_ids = $forum->getForumListId();
    foreach($board_ids as $board_id){
        $board_arr = array();
        $board_arr['board_id'] = $board_id;
        $board_arr['board_name'] = $forum->getForumName($board_id);
        $sub_forum_list = $forum->getSubforums($board_id);
        foreach($sub_forum_list as $forum_list_arr){
            $forum_list_arr['num_of_threads'] = $forum->countThreads($forum_list_arr['fid']);
            if($forum->hasRightsToViewForum($forum_list_arr['fid'], $user_role['rights'])){
                $board_arr['forum'][] = $forum_list_arr;
            }
        }
        array_push($forum_arr, $board_arr);
    }
    $api_tools->outputContent($forum_arr);
}



