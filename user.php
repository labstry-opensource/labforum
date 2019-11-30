<?php
if(@$_GET['check'] != 'password')
  require_once('connect.php');
  $username = @$_POST['username'];
  $checkrow = mysqli_query($connect, "SELECT * FROM users WHERE username='$username';");
  if(mysqli_num_rows($checkrow)){
  	echo 1;
  }else{
  	echo 0;
  }
?>