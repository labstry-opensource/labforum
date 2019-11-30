<?php
if(!isset($_SESSION)) session_start();


$specialteamcheck = mysqli_query($connect,  "SELECT * FROM specialteam WHERE username= '$replyauthor';");
if(!mysqli_num_rows($specialteamcheck)){
	$isspecialteam = 0;
} else $isspecialteam = 1;
if($isspecialteam){
	//If we checked that the user is from special team, then return sp values...
	$replynamechk = mysqli_query($connect, "SELECT * FROM specialteam WHERE username='".$replyauthor."';");
	$replynrow = mysqli_fetch_assoc($replynamechk);
	$replyrole = $replynrow['role_id'];
	$replygroupcheck = mysqli_query($connect, "SELECT * FROM roles WHERE role_id = $replyrole;");
	$replycurrinfo = mysqli_fetch_assoc($replygroupcheck);
	$replyrankname = $replycurrinfo['role_name'];
	$replyrights = $replycurrinfo['rights'];
	$replytagcolor = $replycurrinfo['tagcolor'];
}
else{
	//If he/she is not in the special team, the page will check for normal team member
	$replycheck = mysqli_query($connect, "SELECT score FROM users WHERE username='".$replyauthor."';");
	$replycheckrow = mysqli_fetch_assoc($replycheck);
	$replyscore = $replycheckrow['score'];
	$replyrankchk = mysqli_query($connect, "SELECT * FROM rank WHERE min_mark <= $replyscore ORDER BY min_mark DESC LIMIT 1;");
	$replycurrinfo = mysqli_fetch_assoc($replyrankchk);
	$replyrankname = $replycurrinfo['rname'];
	$replyrights = $replycurrinfo['read'];
	$replytagcolor = $replycurrinfo['tagcolor'];
	$replyisspecialteam = 0;
}
	//Check if user has all the rights
	@$replyrightschk = mysqli_query($connect, "SELECT * FROM roles WHERE role_id=".$replyrole.";");
	@$replyrightqrr = mysqli_fetch_assoc($replyrightschk);
	@$replyedit = $replyrightqrr['r_edit'];
	@$replydel = $replyrightqrr['r_del'];
	@$replypromo = $replyrightqrr['r_promo'];
	@$replyhide = $replyrightqrr['r_hide'];
	@$replymanage = $replyrightqrr['r_manage'];


?>
