<html>
<head>
	<Title>My Labstry</Title>
</head>
<body>
<?php
session_start();
if(@$_SESSION['username']){
	$viewpage = "Personal";
	//include("forum/subheader.php");
}	
else{
	echo "<script>windows.location = 'login.php'</script>";
	header("Location: loggin.php");
}
?>

</body>
</html>