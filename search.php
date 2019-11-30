<?php
  if(!isset($_SESSION)){
    session_start();
  }
  require_once('connect.php');
  //Check the user-timezone to display the time correctly
  $check= mysqli_query($connect, "SELECT * FROM usertz u, users s WHERE s.id= u.id AND s.username='".@$_SESSION['username']."';");
  $row=mysqli_fetch_assoc($check);
  $usertz= $row['timezid'];
  $check = mysqli_query($connect, "SELECT tz from timezone WHERE timezid='$usertz';");
  $row = mysqli_fetch_assoc($check);
  $usertime = $row['tz'];
  mysqli_query($connect, "SET SESSION time_zone = '$usertime';");
  $check = mysqli_query($connect, "SELECT NOW();");
  $trow = mysqli_fetch_assoc($check);
?>
<html>
 <head>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
   <?php 
     $keyword = @$_GET['keywords'];
     if($keyword != NULL) echo "<title>正在搜尋 $keyword ... - Labo 論壇 </title>";
     else echo "<title>搜尋 - Labo 論壇</title>";
   ?>
   
   <!-- 
    This is not required. Stylesheet is already included in the index main page
    <link rel="stylesheet" href="../menu/dynamicmenu.css"/> -->
   <link rel="stylesheet" href="searchmenu.css"/>
   <style type="text/css">
   a{
    text-decoration: none;
    color:black;
   }
   #searchinput{
    border:none;
    border-bottom: 2px solid white;
    transition: border 0.5s ease-out;
   }
   #searchinput:focus{
    outline: none;
    border-bottom: 2px solid #c4c4c4;
   }
   .searchthread{
    display:block;
    background-color: #005cff;
    width: 600px;
    margin-left:150px;
    margin-bottom: 14px;
    border-radius: 2px;
    background:#add8e6
}
@media screen and (max-width: 480px){
  .searchthread{
    margin-left:0px;
    width: 98%;
    margin: 0 auto;
    margin-bottom: 14px;
  }
  .notfoundhint{
    text-align: center;
  }
}
   </style>
 </head>
 <body>
   <?php 
     $match = @$_GET['keywords'];
     if($match){
       $check= mysqli_query($connect, "SELECT * FROM threads WHERE topic_name LIKE '%".$match."%' ORDER BY date DESC, date ASC;");
       if(mysqli_num_rows($check)){
         while ($row = mysqli_fetch_assoc($check)){
           echo "<a class='searchthread' href='thread.php?id=".$row['topic_id']."'>";
           echo "<div style='font-size:18px'>".$row['topic_name']."</div><br/>";
           echo "<div style='font-size:14px'>".$row['topic_creator']."| ".$row['date'];
           $innercheck = mysqli_query($connect, "SELECT COUNT(*) FROM replies WHERE topic_id=".$row['topic_id'].";");
           $innerrow = mysqli_fetch_assoc($innercheck);
           echo "| 回覆：".$innerrow['COUNT(*)']."</div>";
           echo "</a>";
         }
       }else{
          echo "<h3 class='notfoundhint'>沒有找到相符的帖子</h3>";
       }
     }
   ?>


 </body>
 </html>
 <?php
 if(isset($_POST['searchkey'])){
    $keyword= @$_POST['searchkey'];
    $url= "search.php?keyword=$keyword";
    echo $keyword;
    echo "<script>window.location='$url';</script>";
 }
?>
