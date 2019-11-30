<?php
  session_start();
  require('../connect.php');
  if(@$_SESSION["username"]){
?>
<html>
  <head>
  <link rel="stylesheet" href="../menu/dynamicmenu.css"/>
  <title>Labo 論壇- 所有論壇用戶</title>
  </head>
  <body>
  <?php include("../menu/header.php"); 
   echo "<center><h1>Members</h1><br/>";
   $check = mysql_query("SELECT * FROM users");
   $rows = mysql_num_rows($check);
   while($row = mysql_fetch_assoc($check)){
     $id= $row['id'];
     echo "<a href='profile.php?id=$id'>".$row['username']."</a><br/>"; 
   }
   echo "</center>";
    ?>
  </body>
</html>
<?php
  if(@$_GET['action']== "logout"){
  	session_destroy();
  	header("Location: ../login.php");
  }
  }else{
  	echo "You must be logged in";
  	header("Location: login.php");
  }
?>