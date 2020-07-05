<?php

//Deprecation Notice.
// Calling classes file within api folder is deprecated and no longer actively supported
include_once dirname(__FILE__) . '/deprecated.php';

class AddReply{
	public $pdoconnect;
	public $pdotoolkit;

	public $threadid;
	public $latestreplynumber;

	public $replycontent;
	public $replytitle;

	public function __construct($pdoconnect, $pdotoolkit, $threadid){
		$this->pdoconnect = $pdoconnect;
		$this->pdotoolkit = $pdotoolkit;
		$this->threadid = $threadid;
		$this->getLatestReplyNumProp();
	}

	public function getLatestReplyNumProp(){
		$stmt = $this->pdoconnect->prepare("SELECT MAX(reply_id) FROM replies WHERE topic_id = ?");
		$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
		$stmt->execute();
		$replycnt = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->latestreplynumber = $replycnt['MAX(reply_id)'];
	}

	public function submitReply($replytitle, $replycontent){
		if(@$_SESSION['username']){
			$this->latestreplynumber++;
			$stmt = $this->pdoconnect->prepare("INSERT INTO replies 
				(topic_id, reply_id, reply_topic, reply_content, reply_creator, hiddeni, date)
				VALUES
				(?,?,?,?,?,0,NOW())
			");
			$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
			$stmt->bindValue(2, $this->latestreplynumber, PDO::PARAM_INT);
			$stmt->bindValue(3, $replytitle, PDO::PARAM_STR);
			$stmt->bindValue(4, $replycontent, PDO::PARAM_STR);
			$stmt->bindValue(5, @$_SESSION['username'], PDO::PARAM_STR);
			$stmt->execute();
			return true;
		}
		return false;
	}

}


?>