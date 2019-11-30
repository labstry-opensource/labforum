<?php
require_once('connect.php');
$username = @$_GET['username'];
$vcode = @$_GET['vcode'];
$regcheck = mysqli_query($connect, "SELECT * FROM reg_freeze WHERE username ='".$username."' AND verification='".$vcode."';");
if(mysqli_num_rows($regcheck)){
	//GET THE PROPERTY OF USERS
	$innercheck = mysqli_fetch_assoc($regcheck);
	$username = $innercheck['username'];
	$password = $innercheck['password'];
	$email = $innercheck['email'];
	$vday = $innercheck['vday'];
	mysqli_query($connect, "INSERT INTO users (username, password, email, date) VALUES ('".$username."', '".$password."', '".$email."', '".$vday."');");
	mysqli_query($connect, "DELETE FROM reg_freeze WHERE username='".$username."';");
?>
<html>
<head>
<style>
.dialog{
	width:40%;
	margin: 0 auto;
	text-align: center;
	border-radius: 5px;
	background-color: orange;
}
</style>
<title>電郵核對成功</title>
</head>
<body>
<div class='dialog'>
你的Email 已經成功核對。</br>
<a href='login.php'>
<img src='images/success.png' style="width: 40px; height: 40px" />
</a>
</div>
</body>
</html>
<?php }else{ ?>
<html>
<head>
<style>
.dialog{
	width:40%;
	margin: 0 auto;
	text-align: center;
	border-radius: 5px;
	background-color: orange;
}
</style>
<Title>無法核對你的ID</Title>
</head>
<body>
<?php
	echo "<div class='dialog'>";
	echo "\n你輸入的資料有誤，請重新再試";
	echo "\n</br>";
	echo "\n<a href='index.php'>";
	echo "\n<img src='images/success.png' style='width: 40px; height: 40px' />";
	echo "\n</a>";
	echo "\n</div>";
?>
</body>
</html>
<?php
}
?>