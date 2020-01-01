<?php

//include_once($_SERVER['DOCUMENT_ROOT']."/classes/Users.php");

class AuthorProp{
	public $pdoconnect;
	public $pdotoolkit;

	public $threadid;
	public $userid;
	public $username;
	public $profilepic;
	public $roleid;
	public $rolename;
	public $color;
	public $right;

	public function __construct($pdoconnect, $pdotoolkit, $threadid){
		$this->threadid = $threadid;
		$this->pdoconnect = $pdoconnect;
		$this->pdotoolkit = $pdotoolkit;


		//Check database by a connecting query
		if(!$this->checkUserBySpecialTeam()) $this->checkUserByNormalUser();

	}
	public function checkUserBySpecialTeam(){
		$stmt = $this->pdoconnect->prepare("SELECT 
			`userspace`.`users`.`id`,
			`userspace`.`users`.`username`,
			`php_forum`.`specialteam`.role_id, 
			`php_forum`.`roles`.role_name, 
			`php_forum`.`roles`.tagcolor, 
			`php_forum`.`roles`.rights

			 FROM 
			 `php_forum`.`threads`, 
			 `php_forum`.`specialteam`, 
			 `php_forum`.`roles`,
			 `userspace`.`users`

			 WHERE 
			 `php_forum`.`specialteam`.`role_id` = `php_forum`.`roles`.`role_id` AND
			 `php_forum`.`threads`.`topic_creator` = `php_forum`.`specialteam`.`username` AND 
			 `userspace`.`users`.`username` = `php_forum`.`threads`.`topic_creator` AND 
			 `php_forum`.`threads`.topic_id = ?"
		);

		$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
		$stmt->execute();

		if($getdbdata = $stmt->fetch(PDO::FETCH_ASSOC)){
			$this->userid = $getdbdata['id'];
			$this->username= $getdbdata['username'];
			$this->roleid = $getdbdata['role_id'];
			$this->rolename = $getdbdata['role_name'];
			$this->color = $getdbdata['tagcolor'];
			$this->right = $getdbdata['rights'];
			return true;
		}
		return false;
	}

	public function checkUserByNormalUser(){
		//Get user property first
		$stmt = $this->pdoconnect->prepare("SELECT 
			`userspace`.`users`.`id`,
			`userspace`.`users`.`username` 
			FROM
			`userspace`.`users`,
			`php_forum`.`threads`

			WHERE
			`php_forum`.`threads`.`topic_creator` = `userspace`.`users`.`username` AND
			`php_forum`.`threads`.`topic_id` = ?");

		$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
		$stmt->execute();
		$userdetails = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->userid = $userdetails['id'];
		$this->username = $userdetails['username'];

		//Get Ranking
		$this->getNormalRankingProp();
	}

	public function getNormalRankingProp(){
		$stmt = $this->pdoconnect->prepare("
			SELECT `rank`.rname, `rank`.read, `rank`.tagcolor
			FROM `rank` WHERE `rank`.`min_mark` < 
				(SELECT `userspace`.`users`.`score` 
				FROM `userspace`.`users` 
				WHERE `userspace`.`users`.`id` = ? )
			");
		$stmt->bindValue(1, $this->userid, PDO::PARAM_STR);
		$stmt->execute();
		$rank = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->rolename = $rank['rname'];
		$this->right = $rank['read'];
		$this->color = $rank['tagcolor'];
	}
	public function isSessionAuthor(){
		$sessionid = @$_SESSION['id'];
		if($sessionid == $this->userid){
			return true;
		}
		return false;
	}
}

class ReplyAuthorProp extends AuthorProp{
	public $replyid;
	
	public $users;
	

	public function __construct($pdoconnect, $pdotoolkit, $threadid, $replyid){
		$this->threadid = $threadid;
		$this->replyid = $replyid;
		$this->pdoconnect = $pdoconnect;
		$this->pdotoolkit = $pdotoolkit;


		//Check database by a connecting query
		if(!$this->checkUserBySpecialTeam()) $this->checkUserByNormalUser();
		$users = new Users($pdoconnect, $pdotoolkit);
		$users->getUserPropById($this->userid);

		$this->profilepic = $users->profilepic;

	}
	public function checkUserBySpecialTeam(){
		$stmt = $this->pdoconnect->prepare("SELECT 
			`userspace`.`users`.`id`,
			`userspace`.`users`.`username`,
			`php_forum`.`specialteam`.role_id, 
			`php_forum`.`roles`.role_name, 
			`php_forum`.`roles`.tagcolor, 
			`php_forum`.`roles`.rights

			 FROM 
			 `php_forum`.`replies`, 
			 `php_forum`.`specialteam`, 
			 `php_forum`.`roles`,
			 `userspace`.`users`

			 WHERE 
			 `php_forum`.`specialteam`.`role_id` = `php_forum`.`roles`.`role_id` AND
			 `php_forum`.`replies`.`reply_creator` = `php_forum`.`specialteam`.`username` AND 
			 `userspace`.`users`.`username` = `php_forum`.`replies`.`reply_creator` AND 
			 `php_forum`.`replies`.topic_id = ? AND
			 `php_forum`.`replies`.reply_id = ?"
		);
		$stmt->bindValue(1, $this->threadid, PDO::PARAM_STR);
		$stmt->bindValue(2, $this->replyid, PDO::PARAM_STR);
		$stmt->execute();

		if($getdbdata = $stmt->fetch(PDO::FETCH_ASSOC)){
			$this->userid = $getdbdata['id'];
			$this->username= $getdbdata['username'];
			$this->roleid = $getdbdata['role_id'];
			$this->rolename = $getdbdata['role_name'];
			$this->color = $getdbdata['tagcolor'];
			$this->right = $getdbdata['rights'];
			return true;
		}
		return false;

	}
	public function checkUserByNormalUser(){
		//Get user property first
		$stmt = $this->pdoconnect->prepare("SELECT 
			`userspace`.`users`.`id`,
			`userspace`.`users`.`username` 
			FROM
			`userspace`.`users`,
			`php_forum`.`replies`

			WHERE
			`php_forum`.`replies`.`reply_creator` = `userspace`.`users`.`username` AND
			`php_forum`.`replies`.`topic_id` = ? AND 
			`php_forum`.`replies`.`reply_id` = ?
			");

		$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
		$stmt->bindValue(2, $this->replyid , PDO::PARAM_INT);
		$stmt->execute();
		$userdetails = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->userid = $userdetails['id'];
		$this->username = $userdetails['username'];

		//Get Ranking
		$this->getNormalRankingProp();
	}
	public function isSessionAuthor(){
		$sessionid = @$_SESSION['id'];
		if($sessionid == $this->userid){
			return true;
		}
		return false;
	}
}

?>