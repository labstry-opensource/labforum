<?php
  session_start();
  require('connect.php');
  if(@$_SESSION["username"]){
?>
<html>
  <head>
  <title>Labo 論壇- 我的帳戶</title>
  <link rel="stylesheet" href="menu/dynamicmenu.css"/>
  </head>
  <body>
  <?php include("menu/header.php"); ?>
  <?php 
   $check = mysql_query("SELECT * FROM users WHERE username ='".$_SESSION['username']."'");
   $rows  = mysql_num_rows($check);
   while($row = mysql_fetch_assoc($check)){
      $username = $row['username'];
      $email = $row['email'];
      $date = $row['date'];
      $replies = $row['replies'];
      $score = $row['score'];
      $topics = $row['topics'];
      $pic = $row['profile_pic'];
   }
   ?>
  <?php echo "<img src='$pic' width='100' height='100'/>" ?><a href="account.php?action=changeimage">更改個人資料相片</a>
  <br/>
  論壇名稱: <?php echo $username; ?> <br/>
  Email:    <?php echo $email; ?> <br/>
  註冊日期: <?php echo $date; ?> <br/>
  回覆數量: <?php echo $replies; ?><br/>
  積分: <?php echo $score; ?><br/>
  主題: <?php echo $topics; ?><br/>
  密碼: *** <a href="account.php?action=changepw">更改密碼</a><br>
  時區： 
  <?php
    $checktime = mysql_query("SELECT * FROM timezone ORDER BY timezid ASC;");
    echo "<form action='account.php?action=timezone' method='POST'>";
    echo "  <select name='timezone' onchange='this.form.submit()'>";
    while ($row = mysql_fetch_assoc($checktime)) {
      echo "  <option value='".$row['timezid']."'>".$row['gmt']."</option>";
    }
    echo "  </select>";
    echo "</form>";
  ?>


  </body>
</html>
<?php
  if(@$_GET['action']=="timezone"){
    $timezid = @$_POST['timezone'];
    $check = mysql_query("SELECT * FROM timezone WHERE timezid='$timezid';");
    $row = mysql_fetch_assoc($check);
    $usertz= $row['timezid'];
    $checkid = mysql_query("SELECT id from users WHERE username='".@$_SESSION['username']."';");
    echo $checkid;
  }
  if(@$_GET['action']== "logout"){
  	session_destroy();
  	header("Location: login.php");
  }
  if(@$_GET['action']=="changeimage"){
     echo "<form action='account.php?action=changeimage' method='POST' enctype='multipart/form-data'><br>
              <br/>
              Available file extension: <b>*.PNG, *.JPG</b></br></br>
              <input type='file' name='image'><br/>
              <input type='submit' name='imagechange' value = 'Change'>
           </form>";
     if(isset($_POST['imagechange'])){
        $error = array();
        $allowed = array('png', 'jpg', 'jpeg');
        $filename = $_FILES['image']['name'];
        $file_e= strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $file_s= $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];

        if(in_array($file_e, $allowed)==false) $errors[] ='This file extension is not allowed';
        if($file_s > 2097152) $errors[]=" The file must be under 2MB";
        if(empty($errors)){
          move_uploaded_file($file_tmp, 'images/'.$_SESSION['username']."-".$filename);
          $image_up = 'images/'.$_SESSION['username']."-".$filename;
          if($query  = mysql_query("UPDATE users SET profile_pic='".$image_up."' WHERE username='".$_SESSION['username']."'"))
            echo "你的個人資料相片已更改";
        }else{
          foreach ($errors as $error) {
             echo $error, '<br/>';
          }
        }
     }
  }
  if(@$_GET['action']== "changepw"){
    echo "<br/><form action='account.php?action=changepw' method='POST' ><br/>
             Current Password: <input type='password' name='password'><br/>
             New Password: <input type= 'password' name='newpassword'><br/>
             Retype Password: <input type='password' name= 'repassword'><br/>
             <input type='submit' name='change'><br/>
             </form><br/>";
    $input_password = @$_POST['password'];
    $newpassword = @$_POST['newpassword'];
    $repassword = @$_POST['repassword'];
    if(isset($_POST['change'])){
      $check = mysql_query("SELECT * FROM users WHERE username= '" .$_SESSION['username']."'");
      $rows  = mysql_num_rows($check);
      while($row = mysql_fetch_assoc($check)){
        $db_password  = $row['password'];
      }
      if(password_verify($input_password, $db_password)){
        if(strlen($newpassword) >=6){
          if($repassword == $newpassword){
            $pwencrypt = password_hash($newpassword, PASSWORD_DEFAULT);
            if($query = mysql_query("UPDATE users SET password ='".$pwencrypt."' WHERE username='".$_SESSION['username']."'")) echo "Password changed";
          } 
          else echo "The new password does not match";
        } 
        else echo "Password must be larger than or equal to 6 characters";
      }
      else echo "The password is incorrect";
    }
  }
} else{
  	echo "You must be logged in";
  	header("Location: login.php");
  }
?>