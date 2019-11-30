<?php
  session_start();
  require('../connect.php');      //連接數據庫 確認身份
  if(@$_SESSION["username"]){
?>
<html>
  <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <link rel="stylesheet" href="../menu/dynamicmenu.css"/>
  <style type="text/css">
    .useraction{
      float:left;
      font-size: 15px;
      color:white;
      margin-left: 200px;
    }
    .useraction a{
      color:white;
    }
    a{
      text-decoration: none;
    }
  </style>
  <title>
  <?php 
  //All we want is Labo 論壇 - XXX 的 Exhibiton being shown
  // in the title
    if(@$_GET['id']){
      $CHECK2 = mysqli_query($connect, "SELECT * FROM users where id='".$_GET['id']."'");
      $rows2 = mysqli_num_rows($CHECK2);
      if($rows2 != 0){
        while($row2 = mysqli_fetch_assoc($CHECK2)){
         echo "Labo 論壇-".$row2['username']."的 Exhibition"; 
         }
        }
      }
  ?>
  </title>
  </head>
  <body>
  <?php include("../menu/header.php");  //讀header及subheader
        $viewpage = "profile";
        include("../menu/subheader.php"); ?> 
  
<!-- <div style="background-color: #ACACAC; clear:both; width: 100%; height: 40px;">
    <h3 class="useraction"><a href="/forumv2/account.php">帳戶設定</a></h3>
    <h3 class="useraction"><a href="/forumv2/account/members.php">找朋友</a></h3>
    <h3 class="useraction"><a href="#">我的帖子</a></h3>
  </div> -->
  <?php
    if(@$_GET['id']){
      $CHECK = mysqli_query($connect, "SELECT * FROM users WHERE id='".$_GET['id']."'");
      $rows = mysqli_num_rows($CHECK);
      $rolecheck = mysqli_query($connect, "SELECT username, visible FROM specialteam WHERE id='".$_GET['id']."';");
      if(mysqli_num_rows($rolecheck)){
          $rolerow = mysqli_fetch_assoc($rolecheck);
          if(($rolerow['username'] != @$_SESSION['username']) && $rolerow['visible'] ==0){
            echo "<div style='clear:both;'>由於該用戶的私隱設定，你無法查看該用戶的空間</div>";
	  }else{
	     while($row = mysqli_fetch_assoc($CHECK)){
             echo "<div style='clear:both;'>
                <h1 style='font-size:25px; display:inline-block;'>".$row['username']."</h1>
                <h3 style='font-size:14px; display:inline-block;'>(uid:".$row['id'].")</h3><br/>
                </div>";
             echo "<img src='../".$row['profile_pic']."' style='width:100px; height:100px;clear:left;'/>";
            echo "<br/>註冊日期：".$row['date'];
            echo "<br/>Email: ".$row['email'];
           echo "<br/>回覆數量：".$row['replies'];
           echo "<br/>積分：".$row['score'];
           echo "<br/>主題數：".$row['topics'];
             }
	  }
      }else{
      if($rows != 0){
        while($row = mysqli_fetch_assoc($CHECK)){
          echo "<div style='clear:both;'>
                <h1 style='font-size:25px; display:inline-block;'>".$row['username']."</h1>
                <h3 style='font-size:14px; display:inline-block;'>(uid:".$row['id'].")</h3><br/>
                </div>";
          echo "<img src='../".$row['profile_pic']."' style='width:100px; height:100px;clear:left;'/>";
          echo "<br/>註冊日期：".$row['date'];
          echo "<br/>Email: ".$row['email'];
          echo "<br/>回覆數量：".$row['replies'];
          echo "<br/>積分：".$row['score'];
          echo "<br/>主題數：".$row['topics'];
        }
      }else{
        header("Location: ../index.php");
      }
    }
    }else{
      header("Location: ../index.php");
    }
  ?>
  <script type="text/javascript">
    $(function(){                              //Using ajax to load webpage instead of using browser reload |||
      $(".useraction a").click(function(e){
        var nanobar =new Nanobar();
        nanobar.go(30);
        e.preventDefault();
        link = this.href;
        $.get(link, function(data){              
          document.open();						//Load new filea
          document.write(data);                  //Write new webpage
          document.close();
          nanobar.go(70);
          $.cache = {};
        }, "text");
        nanobar.go(100);
        history.pushState("","",link);
      }
      )});
   $(function(){
      $("#menuitem").click(function(e){
        var nanobar =new Nanobar();
        nanobar.go(30);
        e.preventDefault();
        link = this.href;
        $.get(link, function(data){
          document.open();
          document.write(data);
          document.close();
          nanobar.go(70);
          $.cache = {};
        }, "text");
        nanobar.go(100);
        history.pushState("","",link);
      }
      )});
  </script>
  <script type="text/javascript" src="/forumv2/nanobar.min.js"></script>
  </body>
</html>
<?php
  if(@$_GET['action']== "logout"){
  	session_destroy();
  	header("Location: login.php");
  }
  }else{
  	echo "You must be logged in";
  	header("Location: login.php");
  }
?>
