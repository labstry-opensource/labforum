<?php

include_once("AuthorProp.php");

class ThreadOperation{
	public $pdoconnect;
	public $pdotoolkit;
	public $threadid;
	public $replyid;

	//Save rights

	public $r_edit;
	public $r_del;
	public $r_promo;

	public function __construct($pdoconnect, $pdotoolkit, $threadid){
		$this->pdoconnect = $pdoconnect;
		$this->pdotoolkit = $pdotoolkit;
		$this->threadid = $threadid;
	}

	public function checkRights(){
		$id = @$_SESSION['id'];
		$stmt = $this->pdoconnect->prepare("
			SELECT `roles`.r_edit, 
			`roles`.`r_del`,
			`roles`.r_promo 
			FROM
			`roles` , `specialteam`
			WHERE
			`specialteam`.id = $id
			AND
			`specialteam`.role_id = `roles`.role_id
			");
		$stmt->execute();

		$rightarr = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->r_edit = $rightarr['r_edit'];
		$this->r_del = $rightarr['r_del'];
		$this->r_promo = $rightarr['r_promo'];
	}
	public function deleteThread(){

		$this->checkRights();
		$authorprop = new AuthorProp($this->pdoconnect, $this->pdotoolkit, $this->threadid);

		if($this->r_del || $authorprop->isSessionAuthor()){
			$stmt = $this->pdoconnect->prepare("DELETE FROM threads WHERE topic_id = ?");
			$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
			$stmt->execute();

			//Also deletes replies
			$stmt = $this->pdoconnect->prepare("DELETE FROM replies WHERE topic_id = ?");
			$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
			$stmt->execute();
		}
	}

	public function deleteReply($replyid){
		$this->checkRights();
		$authorprop = new AuthorProp($this->pdoconnect, $this->pdotoolkit, $this->threadid);

		if($this->r_del || $authorprop->isSessionAuthor()){
			//Deletes replies
			$stmt = $this->pdoconnect->prepare("DELETE FROM replies WHERE topic_id = ? AND reply_id = ?");
			$stmt->bindValue(1, $this->threadid, PDO::PARAM_INT);
			$stmt->bindValue(2, $this->replyid, PDO::PARAM_INT);
			$stmt->execute();
		}
	}

}

?>