<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('connect.php');
if($user = @$_SESSION['username']){
	$checkmyid = mysqli_query($connect, "SELECT id FROM users WHERE username ='$user'");
	$idstr = mysqli_fetch_assoc($checkmyid);
	$id = $idstr['id'];
?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/forum/menu/dynamicmenu.css"/>
<head>
<Title>帳戶設定 - Labo 論壇</Title>
</head>
<style>
.profile{
	float:left;
}
.table{
	display:table;
	border-collapse: collapse;
	width: 95%;
}
.cell{
	display: table-cell;
	padding: 20px 0 20px 0;
}
.row{
	display: table-row;
}
.wrapper{
	width: 95%;
	margin: 0 auto;
	overflow: hidden;
	border-radius: 5px;
}
.blank{
	border:none;
	border-bottom: 2px solid grey;
	display: inline-block;
	height:25px;
	width: 100%;
	font-size: 20px;
	outline: none;
	margin-bottom: 0;
	transition: border-bottom 0.1s ease;
}
.blankborder{
	display: block;
	content: '';
	transform: scaleX(0);
	transition: transform 0.5s ease-in-out;
	border-bottom: 2px solid orange;
	margin-top: -2px;
}
.blank:focus ~.blankborder{
	transform: scaleX(1);
}
.blank:focus{
	border-bottom:none;
	padding-bottom: 4px;
}
#usrtz-menu li{
        list-style:none;
}
#usrtz-menu{
	border: 2px solid orange;
	cursor: pointer;
	outline: 0;
	margin: 0;
	padding:0;
	border-radius:0px 0px 4px 4px;
	background-color:white;
}
.ui-selectmenu-menu ul{
	transition: height 0.5s;
}

#usrtz-menu li:hover{
	color:white;
	background-color:orange;
}
#usrtz-menu li:active{
	
}

.ui-selectmenu-menu {
    padding: 0;
    margin: 0;
    position: absolute;
    top: 0;
    left: 0;
    transition: height 0.5s;
    display: none;
    width: 500px;
}

.ui-selectmenu-open {
    display: block;
}
.ui-selectmenu-button {
    display: inline-block;
    overflow: hidden;
    position: relative;
    text-decoration: none;
    cursor: pointer;
    width: 500px;
    border-radius: 4px 4px 0px 0px;
}
fieldset {
            border: 0;
	 }
#usrtz-button
{
outline: none;
background: linear-gradient(to right, orange 50%, white 50%);
background-size: 200% 100%;
background-position: right bottom;
transition: all .5s ease-out;
}

#usrtz-button:focus{
background-position: left bottom;
}
.ui-menu-divider{
background-color:white;
}
.stylishselector, #visibletoggle{
text-decoration:none;
color:black;
background: linear-gradient(to right, orange 50%, white 50%);
background-size: 200% 100%;
background-position: right bottom;
transition: all .5s ease-out;
border-radius: 4px;
padding-left:10px;
padding-right: 10px;
}

.stylishselector:hover, #visibletoggle:hover{
background-position: left bottom;
}
</style>
<body>
<?php
	require_once("ranking.php");
?>
<div id='contentdiv'>
<?php 
$profilecheck = mysqli_query($connect, "SELECT * FROM users where username = '".$user."'");
$profilerow = mysqli_fetch_assoc($profilecheck);
$id = $profilerow['id'];
$username = $profilerow['username'];
$email = $profilerow['email'];
$regdate = $profilerow['date'];
$reply = $profilerow['replies'];
$score = $profilerow['score'];
$password = $profilerow['password'];
$pic =$profilerow['profile_pic'];
?>
<?php 
echo "<img class='profile' src='/forum/$pic' width='150' height='150' style='vertical-align:middle'/>";
echo "<h1 style='display:inline-block;margin-left:42px;'>$username</h1>";
?>
</br>
<div class='wrapper'>
<?php
if(!@$_GET['action'] == 'edit'){
	echo "<a href='account.php?action=edit'>修改個人資料</a>";
}
?>
<form action='?action=edit' method="POST" enctype="multipart/form-data">
	<div class='title'>ID 設定</div>
	<div class='table' style='clear:both'>
		<div class='row'>
			<div class='cell'>相片</br>
			<?php
			if(@$_GET['action'] == 'edit'){
				//echo "<form method='POST'>";			
				echo "<a href='' class='stylishselector'>選擇個人資料相片</a>";
				echo "<input type='file' id='file' name='profilepic' class='pic'/>";
				echo "<div id='filename'></div>";
				//echo "<input type='submit' id='picupload' name='picupload' value='Upload'></input>";
				//echo "</form>";
			}
			?>
			</div>
		</div>
		<div class='row'>
			<div class='cell'>Email</br>
			<?php 
			if(@$_GET['action'] == 'edit'){
				echo "\n\t\t<input type='text' class='blank' autocomplete='off' name='email' value='$email'/>";
				echo "\n\t\t<span class='blankborder'></span>";
			}else{
				echo $email;
			}
			?>
			</div>
		</div>
		<?php
		if(@$_GET['error'] == 1){
			echo "<div class='row'>\n\t\t\t<div class='cell' style='color:red'>請檢查你輸入的密碼</div>\n\t\t</div>";
		}else if(@$_GET['error'] == 2){
			echo "<div class='row'>\n\t\t\t<div class='cell' style='color:red'>密碼位數不足，請輸入六位以上的密碼</div>\n\t\t</div>";
		}		
		
		?>
		<div class='row'>
			<div class='cell'>密碼</br>
			<?php
			if(@$_GET['action'] == 'edit'){
				echo "\n\t\t<input type='password' class='blank' autocomplete='off' name='password'/>";
				echo "\n\t\t<span class='blankborder'></span>";
			}
			?>
			</div>
		</div>
		<?php
			if(@$_GET['action'] == 'edit'){
			echo "\n\t\t<div class='row'>";
			echo "\n\t\t\t<div class='cell'>重新輸入密碼</br>";
			echo "\n\t\t\t<input type='password' class='blank' autocomplete='off' name='repassword'/>";
			echo "\n\t\t\t<span class='blankborder'></span>";
			echo "\n\t\t\t</div>";
			echo "\n\t\t</div>";
			}
?>
		<div class='row'>
			<div class='cell'>註冊日期</br>
				<?php echo $regdate ?>
			</div>
		</div>
		<div class='row'>
			<!------ Put timezone check here... -->
			<?php
			$checkzone = mysqli_query($connect, "SELECT * FROM timezone;");
                        $checkmytimezone = mysqli_query($connect, "SELECT * FROM usertz WHERE id='$id';");
			$mytimezone = mysqli_fetch_assoc($checkmytimezone);
			$timezone = $mytimezone['timezid'];
			?>

			<div class='cell'>時區及地區</br>
				<?php
				if(@$_GET['action'] != 'edit'){
					while($zone= mysqli_fetch_assoc($checkzone)){
						if($zone['timezid'] == $timezone){
							echo $zone['gmt'];
						}
					}
				
				}else{
				?>
				<select name='usrtz' id='usrtz'>
					<optgroup label="按時區選擇地區">
					<?php
					  $checkzone = mysqli_query($connect, "SELECT * FROM timezone;");
					  $checkmytimezone = mysqli_query($connect, "SELECT * FROM usertz WHERE id='$id';");
					  $mytimezone = mysqli_fetch_assoc($checkmytimezone);
					  $timezone = $mytimezone['timezid'];
					  while($zone = mysqli_fetch_assoc($checkzone)){
					  	echo "<option value='".$zone['timezid']."'";
					  	if($zone['timezid'] == $timezone) echo " selected='selected'>";
					  	else echo ">";
					  	echo $zone['gmt']."</option>";
					  }
?>
					</optgroup>
				</select>
				<?php } ?>
				</br>
				根據設定紀錄，你所在時區目前的時間：
				<?php
			      		  //Check the user-timezone to display the time correctly
  $check= mysqli_query($connect, "SELECT * FROM usertz u, users s WHERE s.id= u.id AND s.username='".@$_SESSION['username']."';");
  $row=mysqli_fetch_assoc($check);
  $usertz= $row['timezid'];
  $check = mysqli_query($connect, "SELECT tz from timezone WHERE timezid='$usertz';");
  $row = mysqli_fetch_assoc($check);
  $usertime = $row['tz'];
  mysqli_query($connect, "SET SESSION time_zone = '$usertime';");
  $check = mysqli_query($connect, "SELECT NOW();");
  $trow = mysqli_fetch_assoc($check)['NOW()'];
  echo $trow;
?>
			</div>
		</div>
		<?php
		//Check if they have enough rights
		$hideprofile = mysqli_fetch_assoc(mysqli_query($connect, "SELECT profile_invisible FROM roles WHERE rights='"
			.$rights."'"))['profile_invisible'];
		if($hideprofile && @$_GET['action']=='edit'){
			echo "<br/><div class='row'>隱藏個人主頁</div><a href='' id='visibletoggle'>";
			$checkvisible = mysqli_fetch_assoc(mysqli_query($connect, "SELECT visible FROM specialteam WHERE id='".$id."';"))['visible'];
			if($checkvisible){
				echo "Off";
			}else{
				echo "On";
			}
			echo "</a><input name='visibleblank' id='visibleblank' style='display:none' value='".$checkvisible."'></div>";
		}
		?>
	</div>
</div>
<input type='submit' value="Submit" name="submit"/>
</form>
</div>
<!--- INITIALIZES JAVASCRIPT -->
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
<script>
					  var menu = $('#usrtz').selectmenu({
					  	change: function(event, ui){
							alert($('#usrtz').val());
							setOptionValue($('#usrtz').val())
						}
					  }).selectmenu('refresh',true);

					  function setOptionValue(value){
					  	var usertz = $('#usrtz');
						usertz.val(value).change();
					  }
					  $('.stylishselector').on('click', function(e){
					  	e.preventDefault();
						$('#file')[0].click();
					  });
					  //Only hide if jquery is enabled
					  $('#file').css('display','none');

					  $('#file').change(function(e){
						var fileName = e.target.files[0].name;
						$('#filename').html("已選擇："+fileName);
					  });

					  //Change anchor upon click
					  $('#visibletoggle').click(function(e){
						e.preventDefault();  
						var content = $('#visibletoggle').html();
						if(content == "On"){
							// Two steps: set text field to 1 and set text to Off
							$('#visibletoggle').html("Off");
							$('#visibleblank').val("1");

						}else{
							 // Two steps: set text field to 0 and set text to On
                                                        $('#visibletoggle').html("On");
                                                        $('#visibleblank').val("0");
						}
					  });
</script>
</body>
</html>
<?php
}
if(isset($_POST['submit'])){
	if(!empty($_FILES['profilepic']['name'])){
	   echo "true";
	   $uploaddir = 'images/';
	   $filename = $username."-".$_FILES['profilepic']['name'];
	   $uploadfile = $uploaddir.$filename;
	   move_uploaded_file($_FILES['profilepic']['tmp_name'], $uploadfile);
	   mysqli_query($connect, "UPDATE users SET profile_pic ='images/".$filename."' WHERE id=$id;");	
	}
	mysqli_query($connect, "UPDATE usertz SET timezid='".@$_POST['usrtz']."' WHERE id='".$id."';");
	mysqli_query($connect, "UPDATE users SET email='".@$_POST['email']."' WHERE username='".$username."';");
	//Saves password if password blank is filled
	if(@$_POST['password']){
		if(@$_POST['password'] == @$_POST['repassword']){
			if(strlen(@$_POST['password']) >= 6){
				$encrypt = password_hash(@$_POST['password'], PASSWORD_DEFAULT);
				mysqli_query($connect, "UPDATE users SET password='".$encrypt."' WHERE username='".$username."';");
			}else{
				echo "<script>window.location = '?action=edit&error=2'</script>";
			}
		}else{
			echo "<script>window.location = '?action=edit&error=1'</script>";
		}
	}
	//echo "<script>window.location = '?'</script>";

	//Saves hiding if available
	//We have to check the rights again
	$hideprofile = mysqli_fetch_assoc(mysqli_query($connect, "SELECT profile_invisible FROM roles WHERE rights='"
                        .$rights."'"))['profile_invisible'];
	if($hideprofile){
		mysqli_query($connect, "UPDATE specialteam SET visible='".@$_POST['visibleblank']."' WHERE id='".$id."';");
	}
}
?>
