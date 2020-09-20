<?php

class AuthorProp{
	public $connect;

	public $threadid;
	public $userid;
	public $username;
	public $profilepic;
	public $roleid;
	public $rolename;
	public $color;
	public $right;

	public function __construct($connect, $thread_id)
    {
		$this->threadid = $thread_id;
		$this->connect = $connect;

		//Check database by a connecting query
		if(!$this->checkUserBySpecialTeam()) $this->checkUserByNormalUser();

	}
	public function checkUserBySpecialTeam()
    {
	    if(!$this->connect->count('users', '*', [
	        'id' => $this->connect->select('specialteam', [
	            '[>]users' => ['specialteam.id' => 'id'],
	            '[>]threads' => ['specialteam.id'  =>  'author'],
            ], 'specialteam.id', [
                'threads.topic_id[=]' => $this->threadid,
            ]),
        ]))
	    {
	        return false;
        };

	    $user_arr = $this->connect->get('users', [
	        '[>]threads' => ['id'  =>  'author'],
            '[>]specialteam' => ['threads.author'  =>  'id'],
            '[>]roles' => ['specialteam.role_id'  =>  'role_id'],
        ],[
            'user.id', 'user.username', 'specialteam.role_id', 'roles.role_name', 'tagcolor', 'rights',
            'profile_invisible',
        ],[
            'threads.topic_id' => $this->threadid,
        ]);

		$this->userid = $user_arr['id'];
        $this->username= $user_arr['username'];
        $this->roleid = $user_arr['role_id'];
        $this->rolename = $user_arr['role_name'];
        $this->color = $user_arr['tagcolor'];
        $this->right = $user_arr['rights'];

        return true;
	}

	public function checkUserByNormalUser()
    {
		//Get user property first
        $user_arr = $this->connect->get('users', [
            '[>]threads' => ['id', 'author'],
        ],[
            'id', 'username',
        ],[
            'threads.topic_id[=]' => $this->threadid,
        ]);

		$this->userid = $user_arr['id'];
		$this->username = $user_arr['username'];

		//Get Ranking
		$this->getNormalRankingProp();
	}

	public function getNormalRankingProp()
    {
	    $rank = $this->connect->get("rank", [
	        'rname', 'read', 'tagcolor'
        ],[
            'min_mark[<]' => $this->connect->get('users' , 'score' ,[
                'id[=]' => $this->userid,
            ])
        ]);
		$this->rolename = $rank['rname'];
		$this->right = $rank['read'];
		$this->color = $rank['tagcolor'];
	}

	public function isSessionAuthor()
    {
		$sessionid = @$_SESSION['id'];
		if($sessionid == $this->userid)
		{
			return true;
		}
		return false;
	}
}

class ReplyAuthorProp extends AuthorProp{
	public $replyid;
	
	public $users;
	

	public function __construct($connect, $pdotoolkit, $threadid, $replyid)
    {
		$this->threadid = $threadid;
		$this->replyid = $replyid;
		$this->pdoconnect = $connect;
		$this->pdotoolkit = $pdotoolkit;


		//Check database by a connecting query
		if(!$this->checkUserBySpecialTeam()) $this->checkUserByNormalUser();
		$users = new Users($connect);
		$users->getUserPropById($this->userid);
		$this->profilepic = $users->profilepic;

	}
	public function checkUserBySpecialTeam()
    {
	    if(!$this->connect->count('users', '*', [
	        'id' => $this->connect->select('specialteam', [
                '[>]users' => ['specialteam.id'  =>  'id'],
                '[>]replies' => ['specialteam.id' =>  'author'],
            ], 'specialteam.id', [
                'replies.topic_id[=]' => $this->threadid,
                'replies.reply_id[=]' => $this->replyid,
            ]),
        ])){
	        return false;
        }

        $user_arr = $this->connect->get('users', [
            '[>]replies' => ['id' => 'author'],
            '[>]specialteam' => ['replies.author' => 'id'],
            '[>]roles' => ['specialteam.role_id' => 'role_id'],
        ],[
            'user.id', 'user.username', 'specialteam.role_id', 'roles.role_name', 'tagcolor', 'rights',
            'profile_invisible',
        ],[
            'replies.topic_id[=]' => $this->threadid,
            'replies.reply_id[=]' => $this->replyid,
        ]);

        $this->userid = $user_arr['id'];
        $this->username= $user_arr['username'];
        $this->roleid = $user_arr['role_id'];
        $this->rolename = $user_arr['role_name'];
        $this->color = $user_arr['tagcolor'];
        $this->right = $user_arr['rights'];
        return true;

	}
	public function checkUserByNormalUser(){
		//Get user property first
        $userdetails = $this->connect->get('users', [
            '[>]replies' =>  ['users.id', 'id'],
        ],[
            'replies.topic_id[=]' => $this->threadid,
            'replies.reply_id[=]' => $this->replyid,
        ]);


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