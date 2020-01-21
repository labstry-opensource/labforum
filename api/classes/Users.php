<?php
class Users{
	public  $pdoconnect;
	public  $pdotoolkit;

	public  $userid;
	public  $username;
	private $password;      //Password should be private
	public  $email;
	public  $replies;
	public  $profilepic;

	public function __construct($pdoconnect, $pdotoolkit){
		$this->pdoconnect = $pdoconnect;
		$this->pdotoolkit = $pdotoolkit;
	}
	public function getUserPropById($userid){
		//Check database
		$this->userid = $userid;
		$stmt = $this->pdoconnect->prepare("SELECT * FROM `userspace`.users WHERE id= ?");
		$stmt->bindValue(1, $userid, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	public function getSafeUserPropById($userid){
		//Check database
		$this->userid = $userid;
		$stmt = $this->pdoconnect->prepare("SELECT id, username, email, profile_pic FROM `userspace`.users WHERE id= ?");
		$stmt->bindValue(1, $userid, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	public function getUserPropByUname($username){
		//Check database
		$this->username = $username;
		$stmt = $this->pdoconnect->prepare("SELECT * FROM `userspace`.users WHERE username= ?");
		$stmt->bindValue(1, $username, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		return $result;
	}
	public function searchUsername($uname){
		//Check database
		$this->username = $uname;
		$stmt = $this->pdoconnect->prepare("SELECT id, username, email, profile_pic FROM `userspace`.users WHERE username LIKE ?");
		$stmt->bindValue(1, '%'.$uname.'%', PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}
	public function reserveUsername($userid, $username){
		//Check if it is reserved
		if($this->checkIfUsernameReserved($username)) return 0;

		$stmt = $this->pdoconnect->prepare("INSERT INTO reserved_usernames VALUES (?, ?)");
		$stmt->bindValue(1, $username);
		$stmt->bindValue(2, $userid);

		$stmt->execute();
		return 1;

	}
	public function deleteReservedUsername($username){
		$stmt = $this->pdoconnect->prepare("DELETE FROM reserved_usernames WHERE reserved_username = ?");
		$stmt->bindValue(1, $username);

		$stmt->execute();
	}

	public function checkIfUsernameReserved($username){
		$stmt = $this->pdoconnect->prepare("SELECT * FROM reserved_usernames WHERE reserved_username = ?");
		$stmt->bindValue(1, $username);

		$stmt->execute();

		if($stmt->fetchAll(PDO::FETCH_ASSOC)) return true;
		else return false;

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
}

?>
