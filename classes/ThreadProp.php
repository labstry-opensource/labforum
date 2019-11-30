<?php

include_once("AuthorProp.php");

class ThreadProp{
	public $pdoconnect;
	public $pdotoolkit;

	public $threadid;
	public $threadname;
	public $threadcontent;
	public $author;
	public $date;
	public $views;

	public $isDraft;
	public $hiddeni;
	public $stickyness;
	public $stickyuntil;
	public $hightlightcolor;
	public $showInIndex;
	public $descript;

	//Call AuthorProp to check whether the session user is the owner
	public $authorprop;


	public function __construct($pdoconnect, $pdotoolkit, $threadid){
		$this->pdotoolkit = $pdotoolkit;
		$this->pdoconnect = $pdoconnect;
		$this->threadid = $threadid;
		$this->authorprop = new AuthorProp($pdoconnect, $pdotoolkit, $threadid);

	}

	public function getThreadProp(){
		$stmt = $this->pdoconnect->prepare("SELECT * FROM threads, `userspace`.`users` 
			WHERE topic_id = ? AND
			threads.author = `userspace`.`users`.`id`;
			");
		$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
		$stmt->execute();
		$threadarr =  $stmt->fetch(PDO::FETCH_ASSOC);

		$this->threadname = $threadarr['topic_name'];
		$this->threadcontent = $threadarr['topic_content'];
		$this->author = $threadarr['username'];
		$this->date = $threadarr['date'];
		$this->views = $threadarr['views'];

		//Change to bool
		if($threadarr['draft']) $this->isDraft = true;
		else $this->isDraft = false;

		if($threadarr['hiddeni']) $this->hiddeni = true;
		else $this->hiddeni = false;

		if($threadarr['showInIndex']) $this->showInIndex = true;
		else $this->showInIndex = false;

		$this->stickyness = $threadarr['stickyness'];
		$this->stickyuntil = $threadarr['stickyuntil'];
		$this->hightlightcolor = $threadarr['highlightcolor'];
		$this->descript = $threadarr['seo'];

	}
	public function triggerViewsCount(){
		$stmt = $this->pdoconnect->prepare("UPDATE threads SET views = views + 1 WHERE topic_id = ?");
		$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
		$stmt->execute();
	}
	public function getThreadContent(){
		if(!$this->hiddeni) return $this->threadcontent;
		else return "本帖子因內容不恰當而被屏蔽,如有疑問請聯絡管理員";
	}
	public function getAvailableOperations(){
		if($this->authorprop->isSessionAuthor()){
			return "\n<a href=\"post.php?id=".$this->threadid."&mode=edit\" class=\"manedit\">編輯</a> | 
					\n<a href=\"thread.php?id=".$this->threadid."&action=mand\" class=\"manedit\">刪除</a>";
		}
	}
	public function numberOfReplies(){
		$stmt = $this->pdoconnect->prepare("SELECT COUNT(*) FROM replies WHERE topic_id = ?");
		$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
		$stmt->execute();
		$counter =  $stmt->fetch(PDO::FETCH_ASSOC);
		return  $counter['COUNT(*)'];
	}
}

class ReplyProp extends ThreadProp{
	/*
		$pdotoolkit
		$pdoconnect
		$threadid
		$threadname
		$threadcontent
		$author
		$date
		$hiddeni
		$authorprop

	*/


	public $replynumber;

	public function __construct($pdoconnect, $pdotoolkit, $threadid, $replynumber){
		$this->pdotoolkit = $pdotoolkit;
		$this->pdoconnect = $pdoconnect;
		$this->threadid = $threadid;
		$this->replynumber = $replynumber;
		$this->authorprop = new ReplyAuthorProp($pdoconnect, $pdotoolkit, $threadid, $replynumber);

	}
	public function getThreadProp(){
		$stmt = $this->pdoconnect->prepare("
			SELECT reply_topic, reply_content, author , date, hiddeni FROM replies WHERE topic_id = ? AND reply_id = ?");
		$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
		$stmt->bindValue(2, $this->replynumber, PDO::PARAM_INT);
		$stmt->execute();
		$threadarr =  $stmt->fetch(PDO::FETCH_ASSOC);

		if($threadarr['hiddeni']) $threadarr['reply_content'] = "本帖子因內容不恰當而被屏蔽,如有疑問請聯絡管理員";

		return $threadarr;

	}

	public function getThreadContent(){
		if(!$this->hiddeni) return $this->threadcontent;
		else return "本帖子因內容不恰當而被屏蔽,如有疑問請聯絡管理員";
	}

	public function getAvailableOperations(){
		if($this->authorprop->isSessionAuthor()){
			return "\n<a href=\"post.php?id=".$this->threadid."&mode=edit\" class=\"manedit\">編輯</a> | 
					\n<a href=\"thread.php?id=".$this->threadid."&action=mand\" class=\"manedit\">刪除</a>";
		}
	}
}

?>