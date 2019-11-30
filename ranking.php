<?php
require_once('connect.php');
if(session_status() == PHP_SESSION_NONE) session_start();
if($user = @$_SESSION['username']){
	//CHECK IF HE/SHE IS BLOCKED

	//Check whether user is in special team
	$sp = mysqli_query($connect, "SELECT * FROM specialteam WHERE username='".$user."';");
	if(!mysqli_num_rows($sp)){
		//IF THE USER is not found in the special team table, then he/she should be ordinary user
		$check = mysqli_query($connect, "SELECT score FROM `userspace`.users WHERE username='".$user."';");
		$checkrow = mysqli_fetch_assoc($check);
		$score = $checkrow['score'];
		$rankchk = mysqli_query($connect, "SELECT * FROM rank WHERE min_mark <= $score ORDER BY min_mark DESC LIMIT 1");
		$currinfo = mysqli_fetch_assoc($rankchk);
		$rankname = $currinfo['rname'];
		$rights = $currinfo['read'];
		$tagcolor = $currinfo['tagcolor'];
		$isspecialteam = 0;


	}else{
		//If he/she is in special team, then let's check their group and its rights
		$namechk = mysqli_query($connect, "SELECT * FROM specialteam WHERE username='".$user."'");
		$nrow = mysqli_fetch_assoc($namechk);
		$role = $nrow['role_id'];

		//Get id for moderator checking
		$uid = @$_SESSION['id'];

		$groupcheck = mysqli_query($connect, "SELECT * FROM roles WHERE role_id = $role");
		$currinfo = mysqli_fetch_assoc($groupcheck);
		$rankname = $currinfo['role_name'];
		$rights = $currinfo['rights'];
		$tagcolor = $currinfo['tagcolor'];
		$isspecialteam = 1;
	}

	//Check if user has all the rights
	@$rightschk = mysqli_query($connect, "SELECT * FROM roles WHERE role_id=".$role.";");
	@$rightqrr = mysqli_fetch_assoc($rightschk);
	@$myedit = $rightqrr['r_edit'];
	@$mydel = $rightqrr['r_del'];
	@$mypromo = $rightqrr['r_promo'];
	@$myhide = $rightqrr['r_hide'];
	@$mymanage = $rightqrr['r_manage'];
	
}else{
	$rights = 0;
	$rankname = "訪客";

	//The visitors will not have rights to do anything
		//Check if user has all the rights
	$myedit = 0;
	$mydel = 0;
	$mypromo = 0;
	$myhide = 0;
	$mymanage = 0;
}


?>
