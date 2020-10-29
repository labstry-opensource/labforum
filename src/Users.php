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

	public function __construct($connect){
		$this->connect = $connect;
	}
	public function getUserPropById($userid){
		//Check database
		$this->userid = $userid;

		return $this->connect->get('users', '*', [
			'id[=]' => $this->userid,
		]);
	}
	public function getUsernameById($userid){
		return $this->connect->get('users', 'username', [
			'id[=]' => $userid,
		]);
	}
	public function getSafeUserPropById($userid){
		//Check database
		$this->userid = $userid;

		return $this->connect->get('users', [
			'id', 'username', 'email', 'profile_pic'
		], [
			'id' => $this->userid,
		]);
	}
	public function getUserPropByUname($username){
		//Check database
		$this->username = $username;

		return $this->connect->get('users', '*', [
			'username' => $this->username,
		]);
	}
	public function getUserPropByEmail($email){
		//Check database
		$this->email = $email;
		return $this->connect->get('users', '*' , [
			'email' => $email,
		]);
	}

	/* From 3.0.5.
	   This function accepts pagination parameters.
	*/
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
		$this->connect->insert('reserved_usernames', [
			'reserved_username' => $username,
			'reserved_by_id' => $userid,
		]);
		return 1;
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
		return $this->connect->select('reserved_usernames', 'reserved_username' , [
			'reserved_by_id' => $id,
		]);
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
		$user_arr = $this->connect->get('users', [
			'username', 'id'
		] , [
			'ORDER' => [
				'id' => "DESC"
			]
		]);
		$this->username = $user_arr['username'];
		$this->userid = $user_arr['id'];
	}
	public function getUserCount(){
		return $this->connect->count('users' , '*' );
	}
	public function isUsernameExists($uname){
		return $this->connect->count('users', '*', [
			'username' => $uname,
		]);
	}
	public function isEmailValid($email){
		return $this->connect->count('users', '*', [
			'email' => $email
		]);
	}
	public function registerUser($user_arr){

	}
	public function setPassword($userid, $password, $repassword = null){
		if($password === $repassword || $repassword === null){
			$password = password_hash($password, PASSWORD_DEFAULT);
		}else{
			return false;
		}
		$this->connect->update('users', [
			'password' => $password,
		],[
			'id' => $userid,
		]);
	}
	public function validatePassword($userid, $password){
		$user_arr = $this->getUserPropById($userid);
		return password_verify( $password, $user_arr['password']);
	}
}

?>
