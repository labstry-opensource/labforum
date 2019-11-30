<html>


<?php
if(@$_SESSION['id']){
	require_once("connect.ohp");
	$id = @$_SESSION['id'];
	//Firstly, we will return all the messages of the current user
	$getmsg = mysqli_query($connect, "SELECT * FROM Messages WHERE receive_id = $id");
	while($msg = mysqli_fetch_assoc($getmsg)['message']){
		echo $msg;
	}
}
else{
	echo "<script>windows.location = 'index.php'</script>";
}
?>

</html>
