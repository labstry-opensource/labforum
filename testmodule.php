
<?php
	$minrightchk = mysqli_query($connect, "SELECT min_right FROM maintainance");
	$required_rights = mysqli_fetch_assoc($minrightchk)['min_right'];
	if($testmode){
		//That means we are testing the site
		if($rights < $required_rights){
			echo "<script>window.location = 'maintainance.php'</script>";
			header("Location: maintainance.php");
		}
	}
?>