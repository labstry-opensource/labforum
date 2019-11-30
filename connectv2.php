<?php
/* mysqli connection part starts here... */

class connectionAttr2{
	public $host = "127.0.0.1";
	public $username = "playground";
	public $password = "plyg2043";
	public $database = "php_forum";

	function startMysqliConnection(){
		//The old deprecated function for legacy function to continue function
		$connect = mysqli_connect($this->host,$this->username, $this->password) or die("Couldn't connect to database");
		mysqli_set_charset($connect, 'utf8');
		mysqli_select_db($connect, $this->database) or die("Couldn't select proper database");

		//To prevent character displayed incorrectly, we must use utf-8
		mysqli_query($connect, "SET CHARACTER_SET_CLIENT='utf8'");
		mysqli_query($connect, "SET CHARACTER_SET_RESULTS='utf8'");

		//Set the correct timezone
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

		return $connect;
	}

	function startPDOConnection(){
	  	//Connecting to the database via PDO
		try{
			$connect = new PDO("mysql:host=".$this->host.";dbname=".$this->database.";charset=utf8", $this->username, $this->password);
			//fallback for PHP prior to 5.3.6
			$connect->exec("SET names utf8");

			//To prevent character displayed incorrectly, we must use utf-8
			$connect->exec("SET CHARACTER_SET_CLIENT='utf8'");
			$connect->exec("SET CHARACTER_SET_RESULTS='utf8'");
			
			//Set the correct timezone
			//Check the user-timezone to display the time correctly

			$timezonechk = $connect->query("SELECT * FROM usertz u, `userspace`.users s WHERE s.id= u.id AND s.username='".@$_SESSION['username']."'");
			$tzresult = $timezonechk -> fetch(PDO::FETCH_ASSOC);

			$usertz = $tzresult['timezid'];
			
			$checktzid = $connect->query("SELECT tz from timezone WHERE timezid='".$usertz."'");
			$gettzid = $timezonechk -> fetch(PDO::FETCH_ASSOC);
			$usertime = $gettzid['tz'];
			$connect->exec("SET SESSION time_zone = '$usertime';");

			//used for account.php
			$nowcheck = $connect->query("SELECT NOW()");
			$trow = $nowcheck->fetch(PDO::FETCH_ASSOC);

			return $connect;
		}
		catch(PDOException $e){
			echo "Cannot connect to database. Error: ".$e->getMessage();
		}

	}
}

class PDOToolkit2{
	//This toolkit is written for migration to pdo connection
	/*
		PHP class PDOToolkit

		function rowCounter($conn, $query): A mechanical counter for a query result
			It counts all the row one by one until it reaches the last row

		function rowCounterWithLimit($conn, $table, [$sqllimit]): Uses count * to count within a table with certain limitations
			If $sqllimit is omitted, no limitations is given

		function rowCounterWithPara($conn, $sql, ...$params): Use bind parameters to find number of rows


		Suggest using rowCounterWithLimit as its not a mechanical
	 */

	function rowCounter($conn, $query){
		//Try the query again and check the nunber of rows
		$rows = $conn->query($query)->fetchAll();
		$nrow=0;
		foreach($rows as $row){
			$nrow++;
		}
		return $nrow;
	}

	function rowCounterWithLimit($conn, $table, $sqllimit = "1=1"){
		//This function returns a COUNT(*) from the SQL Table with $sqllimit
		$sqlbuilder = "SELECT COUNT(*) FROM ".$table." WHERE ".$sqllimit.";";
		$sqlquery = $conn->query($sqlbuilder)->fetch(PDO::FETCH_ASSOC);
		$count = $sqlquery['COUNT(*)'];
		return $count;
	}

	function rowCounterWithPara($conn, $sql, ...$params){
		//breakdown the sql statement
		//WARNING: using this function will neglect all the params in the sql columns 
		
		$alter = explode(" ", $sql);

		$sqlbuilder = ""; 

		//Get the rest of the sql string
		$fromflag = 0;
		for($i = 0; $i < sizeof($alter) ;$i++){
			if($alter[$i] == "FROM" || $alter[$i] == "from") $fromflag = 1;
			if($i==1){
				$sqlbuilder .= " COUNT(*) ";
				continue;
			}
			if(($i != 0) && (!$fromflag)) continue;

			$sqlbuilder .= $alter[$i];
			if($i != sizeof($alter)-1 ) $sqlbuilder .= " ";
		}
		//echo $sqlbuilder;

		$parastatm = $conn->prepare("SELECT COUNT(*) FROM checkin WHERE id = ? AND TO_DAYS(checkindate) = TO_DAYS(NOW())");
		$i=1;
		$arr = array();
		foreach ($params as $param){
			array_push($arr, $param);
		}
		$parastatm->execute($arr);
		$newrows = $parastatm->fetch(PDO::FETCH_ASSOC);
		$nrow = $newrows['COUNT(*)'];
		return $nrow;
	}

}

$attribute = new connectionAttr2;
$pdotoolkit = new PDOToolkit2;
/*

We could initialise function startMysqliConnection() to replace these statements.

ini_set('dislay_errors',1);
$host = "localhost";
$username = "playground";
$password = "plyg2043";
$connect = mysqli_connect($host,$username, $password) or die("Couldn't connect to database");
unset($host, $username, $password);

mysqli_query($connect, "SET CHARACTER_SET_CLIENT='utf8'");
mysqli_query($connect, "SET CHARACTER_SET_RESULTS='utf8'");
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
*/

$connect = $attribute->startMysqliConnection();
$pdoconnect = $attribute->startPDOConnection();



/* mysqli connection part ends here...
   
   pdo connection starts...
 */

?>
