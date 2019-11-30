<?php
if(!isset($_SESSION)) session_start();
require_once('connect.php');
$authorquery = mysqli_query($connect, "SELECT topic_creator FROM threads WHERE topic_id = '$threadid'; ");
$r_author = (mysqli_fetch_assoc($authorquery))['topic_creator'];
$specialteamcheck = mysqli_query($connect,  "SELECT * FROM specialteam WHERE username= '$r_author';");
if(!mysqli_num_rows($specialteamcheck)){
	$isspecialteam = 0;
} else $isspecialteam = 1;
if($isspecialteam){
	//If we checked that the user is from special team, then return sp values...
	$r_namechk = mysqli_query($connect, "SELECT * FROM specialteam WHERE username='".$r_author."';");
	$r_nrow = mysqli_fetch_assoc($r_namechk);
	@$r_role = $r_nrow['role_id'];
	$r_groupcheck = mysqli_query($connect, "SELECT * FROM roles WHERE role_id = $r_role;");
	$r_currinfo = mysqli_fetch_assoc($r_groupcheck);
	$r_rankname = $r_currinfo['role_name'];
	$r_rights = $r_currinfo['rights'];
	$r_tagcolor = $r_currinfo['tagcolor'];
}
else{
	//If he/she is not in the special team, the page will check for normal team member
	$r_check = mysqli_query($connect, "SELECT score FROM `userspace`.users WHERE username='".$r_author."';");
	$r_checkrow = mysqli_fetch_assoc($r_check);
	$r_score = $r_checkrow['score'];
	$r_rankchk = mysqli_query($connect, "SELECT * FROM rank WHERE min_mark <= $r_score ORDER BY min_mark DESC LIMIT 1;");
	$r_currinfo = mysqli_fetch_assoc($r_rankchk);
	$r_rankname = $r_currinfo['rname'];
	$r_rights = $r_currinfo['read'];
	$r_tagcolor = $r_currinfo['tagcolor'];
	$r_isspecialteam = 0;
	$r_role = 0;
}
	//Check if user has all the rights
	$r_rightschk = mysqli_query($connect, "SELECT * FROM roles WHERE role_id=".$r_role.";");
	@$r_rightqrr = mysqli_fetch_assoc($r_rightschk);
	if(@$_SESSION['username']== $r_author){
		$r_edit = $r_rightqrr['r_edit'];
		$r_del = $r_rightqrr['r_del'];
		$r_promo = $r_rightqrr['r_promo'];
		$r_hide = $r_rightqrr['r_hide'];
		$r_manage = $r_rightqrr['r_manage'];
	}else{
		$r_edit = 0;
		$r_del = 0;
		$r_promo = 0;
		$r_hide = 0;
		$r_manage = 0;
	}


?>
