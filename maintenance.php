<?php
if(!isset($_SESSION)) session_start();
include_once dirname(__FILE__)."/api/classes/UserRoles.php";


$userrole = new UserRoles($pdoconnect);
$roles_arr = $userrole->getUserRole(@$_SESSION["id"]);

class Maintainance{
	public $pdoconnect;

	public function __construct($pdoconnect){
		$this->pdoconnect = $pdoconnect;
	}
	public function checkIfMaintaining(){
		$stmt = $this->pdoconnect->prepare("SELECT COUNT(*) 'cnt' FROM maintainance");
		$stmt->execute();

		$resultset = $stmt->fetch(PDO::FETCH_ASSOC);
		if($resultset['cnt']) return true;
		else return false;
	}
	public function getMinUserRights(){
		$stmt = $this->pdoconnect->prepare("SELECT min_right FROM maintainance");
		$stmt->execute();
		$resultset = $stmt->fetch(PDO::FETCH_ASSOC);
		return $resultset["min_right"];
	}
}
$maintainance = new Maintainance($pdoconnect);
if(($maintainance->checkIfMaintaining() === false) || $roles_arr['rights'] >= $maintainance->getMinUserRights()){
	return;
}


?>
<html>
<head>
<style>
body{
	margin: 0;
	background-color: #00c5ff;
	text-align: center;
	color:white;
}
a{
	text-decoration: none;
	color:white;
}
</style>
<Title>論壇正在更新</Title>
</head>
<?php

?>
<body>
<h1 style='font-size: 40px; margin-top: 280px; '>升級中&emsp;UPDATING</h1></br>
<h1 style='text-align: center; font-size: 20px; margin-top: 40px;color:white;'>
對唔住，Forum 正在更新中...</br>
由於<?php
    $statement =  $pdoconnect->prepare("SELECT * FROM maintainance");
    $statement->execute();
    $details = $statement->fetch(PDO::FETCH_ASSOC);
    	echo $details['reason'];
    ?>
，因此論壇暫時無法使用</br>
等陣見
</br>
</br>
更新時間: <?php echo $details['s_date']."-".$details['e_date']; ?>
<br/>
<br/>
<br/>
<a href="../login.php?target=forum">以特別身份登入...</a>
</h1>

</body>
<?php
    $statment = $pdoconnect->prepare("SELECT NOW() 'now");
    $statment->execute();
    $now_arr = $statment->fetch(PDO::FETCH_ASSOC);
	$now = $now_arr['now'];
	echo $now;
	
	$diff = strtotime($now) - strtotime($details['e_date']);
	
	//$seconds = floor(($diffe - ($days * 86400) - ($hours * 3600) - ($minutes*60)));
	/* We are making a timer here...
	 * we will redirect users if $diff is GE zero
	 */
	//Test bed
	if($diff >=0) echo "<script>window.location = 'index.php'</script>";
	die();
?>
</html>
