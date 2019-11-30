<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script> window.location = '../register.php' </script>
<head>
	<title>註冊 - Labo </title>
    <link rel="stylesheet" href="menu/dynamicmenu.css"/>
<style type="text/css">
	input{
		float:right;
	}
	#regtable{
	        width:300px;
	        margin: 0 auto;
	}
	#regtag{
	        border: 2px solid #00c5ff;
	        background-color: white;
	        border-radius: 15px;
	}
</style>
</head>
<body>
  <?php include("menu/header.php"); ?>
  <h2 style="text-align: center">註冊Labo 賬戶</h2>
  <form action="register.php" method="POST" id="regtable" style="width:300px;">
	論壇名稱: <input type="text" name="username">
	</br>密碼:<input type="password" name="password">
	</br>確認密碼:<input type="password" name="repassword">
	</br>Email:<input type="email" name="email">
	</br><input id="regtag" type="submit" name="submit" value="註冊" style="width:95%; margin:0 auto">
	</br> 已有帳戶？ <a href="login.php">登入</a>
  </form>
</body>
</html>

<?php
    require('connect.php');
	$username = @$_POST['username'];
	$password = @$_POST['password'];
	$repass = @$_POST['repassword'];
	$email = @$_POST['email'];
if(isset($_POST['submit'])) {
	if($username && $password && $repass && $email){
		$check = mysqli_query($connect, "SELECT * FROM users WHERE username='$username';");
		if(mysqli_num_rows($check)){
			echo "用戶名已存在，請使用其他名稱";
		}else 
		if(strlen($username) >= 5 && strlen($username)<25 && strlen($password) >= 6){
			if($repass == $password) {
				$phash = password_hash($password, PASSWORD_DEFAULT);
				$vcode = md5(rand(0,1000)."hreg".md5(time()));
				/* Temporary suspended for error reason. Enable it to send email
				if($query = mysqli_query($connect, "INSERT INTO  reg_freeze(username, password, email, vday, verification) VALUES ('".$username."','".$phash."', '".$email."', NOW(), '".$vcode."')")){
					  $msg = "Click the button below to start using labo service.</br>\n\t";
					  $msg .= "<a href='https://forum.labstry.com/verify.php?username=".$username."&vcode=".$vcode."'>Start Using My Account</a>";
					  $headers[] ='MIME-Version: 1.0';
					  $headers[] ='Content-type: text/html; charset=utf-8';
					  $headers[] = 'To: '.$username.' <'.$email.'>';
					  $headers[] = 'From: Labo Forum Team <donotreply@labo.com>';
					  $headers[] = 'Reply-To: donotreply@labo.com';
					  $headers[] = 'Return-Path: donotreply@labo.com';
					  
					  //We are sending mail to users' account via this code
					  mail($email, 'Your Labo ID, starts here', $msg, implode("\r\n", $headers));
		              echo "你已經成功註冊. 請到email 確認ID";
		              */
		        //if(myslqli_query($connect, "INSERT INTO users(username, password, email) VALUES("")"))
			}
			else{
				echo "你所填寫的密碼不相符，請重新檢查";
			}
		}
		else{
			if(strlen($username) <5 || strlen($username) > 25){
				echo "論壇名稱必須介乎 5 - 25 個字符之間";
			}
			if(strlen($password)<6) {
				echo "密碼必須大於6或等於個字符";
			}
		}
	}else{
		echo "請填入資料";
	}

}
?>