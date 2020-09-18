<?php
class Users{
	public  $connect;
	public  $pdotoolkit;

	public  $userid;
	public  $username;
	private $password;      //Password should be private
	public  $email;
	public  $replies;
	public  $profilepic;

	public function __construct($connect, $pdotoolkit = null){
		$this->connect = $connect;
		$this->pdotoolkit = $pdotoolkit;
	}
	public function getUserPropById($userid){
		//Check database
		$this->userid = $userid;

		return $this->connect->select('users', '*', [
			'id[=]' => $this->userid,
		]);
	}
	public function getSafeUserPropById($userid){
		//Check database
		$this->userid = $userid;

		return $this->connect->select('users', [
			'id', 'username', 'email', 'profile_pic'
		], [
			'id' => $this->userid,
		]);
	}
	public function getUserPropByUname($username){
		//Check database
		$this->username = $username;

		return $this->connect->select('users', '*', [
			'username' => $username,
		]);
	}
	public function searchUsername($variable, $type='username', $page=null, $count=null){
		//Check database
		$limit_arr = array();

		if(strlen($page) && strlen($count)){
			$max_records = $this->connect->count('users', '*', [
				$type.'[~]' => $variable,
			]);
			$page_counts = ceil($max_records / $count);
			$limit_arr = array(
				'LIMIT' => [$page*$count, $count],
			);
		}
		$where_clause = array_merge(array($type.'[~]' => $variable), $limit_arr);

		$result = $this->connect->select('users', [
			'id', 'username', 'email', 'profile_pic',
		], $where_clause);

		if(strlen($page) && strlen($count)){
			return array(
				'data' => $result,
				'max_records' => $max_records,
				'page_counts' => $page_counts,
			);
		}
		return $result;

	}
	public function reserveUsername($userid, $username){
		//Check if it is reserved
		if($this->checkIfUsernameReserved($username)) return 0;

		return $this->connect->insert('reserved_usernames', [
			'reserved_username' => $username,
			'reserved_by_id' => $userid,
		]);
	}
	public function deleteReservedUsername($username){
		return $this->connect->delete('reserved_usernames',  [
			'reserved_username' => $username,
		]);
	}

	public function checkIfUsernameReserved($username){
		return $this->connect->count('reserved_usernames', '*', [
			'reserved_username' => $username,
		]);
	}

	public function getReservedUsername($id){
		$stmt = $this->pdoconnect->prepare("SELECT reserved_username FROM reserved_usernames WHERE reserved_by_id = ?");
		$stmt->bindValue(1, $id);

		$stmt->execute();

		$resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $resultset;
	}

	public function getUserPropByEmail($email){
		//Check database
		$this->email = $email;
		$stmt = $this->pdoconnect->prepare("SELECT * FROM `userspace`.users WHERE email= ?");
		$stmt->bindValue(1, $this->email, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		return $result;
	}

	public function getUsername(){
		return $this->username;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getProfilePath(){
		return $this->profilepic;
	}
	public function getNewestUser(){
		//Getting the new user and current user count
		$stmt = $this->pdoconnect->prepare("SELECT * FROM `userspace`.users ORDER BY id DESC");
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->username = $user['username'];
		$this->userid = $user['id'];
	}
	public function getUserCount(){
		$stmt = $this->pdoconnect->query("SELECT COUNT(*) FROM `userspace`.users")->fetch(PDO::FETCH_ASSOC);
		return $stmt['COUNT(*)'];
	}
	public function isUsernameExists($uname){
		$stmt = $this->pdoconnect->prepare("SELECT COUNT(*) FROM `userspace`.users WHERE username=?");
		$stmt->bindValue(1, $uname, PDO::PARAM_STR);
		$stmt->execute();
		return ($stmt->fetchColumn() > 0) ? true: false;
	}
	public function isEmailValid($email){
		$stmt = $this->pdoconnect->prepare("SELECT COUNT(*) FROM `userspace`.users WHERE email=?");
		$stmt->bindValue(1, $email, PDO::PARAM_STR);
		$stmt->execute();
		return ($stmt->fetchColumn() > 0) ? true: false;
	}
	public function registerUser($user){

	}
	public function setPassword($userid, $password, $repassword = null){
		if($password === $repassword || $repassword === null){
			$password = password_hash($password, PASSWORD_DEFAULT);
		}else{
			return false;
		}
		$stmt = $this->pdoconnect->prepare('UPDATE `userspace`.users SET password = ? WHERE id = ?');
		$stmt->bindValue(1, $password, PDO::PARAM_STR);
		$stmt->bindValue(2, $userid, PDO::PARAM_INT);
		$stmt->execute();
		$this->password = $password;
	}
	public function validatePassword($userid, $password){
		$user_arr = $this->getUserPropById($userid);
		return password_verify( $password, $user_arr['password']);
	}
}

?>
