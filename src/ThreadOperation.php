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

	public function __construct($pdoconnect, $pdotoolkit = null, $threadid = null){
		$this->pdoconnect = $pdoconnect;
		$this->pdotoolkit = $pdotoolkit;
		$this->threadid = $threadid;
	}

	public function addThreadLog($thread_id, $user_id, $action, $remarks, $visible = "1"){
	    $stmt = $this->pdoconnect->prepare('
	        INSERT INTO laf_threads_operation_log VALUES
	        (:thread_id, :edit_time, :userid, :thread_action, :remarks, :visible)
	    ');
	    $stmt->bindParam(':thread_id', $thread_id, PDO::PARAM_STR);
	    $stmt->bindValue(':edit_time', date('Y-m-d H:i:s'), PDO::PARAM_STR);
	    $stmt->bindParam(':userid', $user_id , PDO::PARAM_STR);
	    $stmt->bindParam(':thread_action', $action , PDO::PARAM_STR);
	    $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);
        $stmt->bindParam(':visible', $visible, PDO::PARAM_STR);
	    $stmt->execute();

    }

    public function getThreadLog($thread_id){
        $stmt = $this->pdoconnect->prepare('
            SELECT l.*, d.*, u.username 
            FROM laf_threads_operation_log l, 
            laf_threads_operation_def d,
            `userspace`.`users` u WHERE 
            l.type = d.type AND 
            l.operator_id = u.id AND
            l.visible = 1 AND
            thread_id = :thread_id 
	    ');
        $stmt->bindParam(':thread_id', $thread_id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

	public function postThread($thread){
	    $stmt = $this->pdoconnect->prepare("INSERT 
                INTO threads (fid, topic_name, topic_content, author, date, draft, rights, seo)
                VALUES(:fid, :thread_topic, :thread_content, :author, NOW(), :draft, :rights, :keyword)");

	    $stmt->bindParam(':fid', $thread['fid'], PDO::PARAM_INT);
	    $stmt->bindParam(':thread_topic', $thread['thread_topic'], PDO::PARAM_STR);
	    $stmt->bindParam(':thread_content', $thread['thread_content'], PDO::PARAM_STR);
        $stmt->bindParam(':author', $thread['author'], PDO::PARAM_INT);
        $stmt->bindParam(':draft', $thread['thread_content'], PDO::PARAM_INT);
        $stmt->bindParam(':rights', $thread['rights'], PDO::PARAM_INT);
        $stmt->bindParam(':keyword', $thread['keyword'], PDO::PARAM_STR);

        $stmt->execute();

        return $this->pdoconnect->lastInsertId();
    }
    public function postReply($reply){

	    $stmt = $this->pdoconnect->prepare('INSERT INTO replies
            (topic_id, reply_id, reply_topic, reply_content, author, hiddeni) VALUES
            (:thread_id, (SELECT MAX(reply_id) + 1 FROM replies m WHERE topic_id = :thread_id), :reply_topic, :reply_content, :id, 0)');

        $stmt->bindParam(':thread_id', $reply['thread_id'], PDO::PARAM_INT);
        $stmt->bindParam(':reply_topic', $reply['reply_topic'], PDO::PARAM_STR);
        $stmt->bindParam(':reply_content', $reply['reply_content'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public function editThread($thread){
	    $stmt = $this->pdoconnect->prepare('UPDATE threads SET 
               topic_name = :thread_topic,
               topic_content = :thread_content, 
               draft = :draft, 
               seo = :keyword,
               rights = :read_permission WHERE topic_id = :id');

	    $stmt->bindParam(':id', $thread['id'], PDO::PARAM_INT);
	    $stmt->bindParam(':thread_topic', $thread['thread_topic'], PDO::PARAM_STR);
	    $stmt->bindParam(':thread_content', $thread['thread_content'], PDO::PARAM_STR);
	    $stmt->bindParam(':draft', $thread['draft'], PDO::PARAM_STR);
	    $stmt->bindParam(':keyword', $thread['keyword'], PDO::PARAM_STR);
	    $stmt->bindParam(':read_permission', $thread['read_permission'], PDO::PARAM_STR);

        $stmt->execute();

        $this->addThreadLog($thread['id'], $_SESSION['id'], '1', '');

        return true;
    }
    public function promoteThread($thread_id){
	    $stmt = $this->pdoconnect->prepare('UPDATE threads SET
	            `stickyness` = \'1\' WHERE `topic_id` = :thread_id');
	    $stmt->bindValue(':thread_id', $thread_id, PDO::PARAM_INT);
	    $stmt->execute();
        $this->addThreadLog($thread_id, $_SESSION['id'], '2', '');
    }
    public function moveThreadToForum($thread_id, $fid){
        $stmt = $this->pdoconnect->prepare('UPDATE threads SET
	            `fid` = :fid WHERE `topic_id` = :thread_id');
        $stmt->bindValue(':thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->bindValue(':fid', $fid, PDO::PARAM_INT);
        $stmt->execute();
        print_r($stmt->errorInfo());
        $this->addThreadLog($thread_id, $_SESSION['id'], '7', '');
    }
    public function demoteThread($thread_id){
        $stmt = $this->pdoconnect->prepare('UPDATE `threads` SET
	            `stickyness` = \'0\' WHERE `topic_id` = :thread_id');
        $stmt->bindValue(':thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->execute();
        $this->addThreadLog($thread_id, $_SESSION['id'], '3', '');
    }

    public function withdrawnFromIndex($thread_id){
	    $stmt = $this->pdoconnect->prepare('UPDATE `threads` SET `showInIndex` = \'0\' WHERE `topic_id` = :thread_id');
	    $stmt->bindValue(':thread_id', $thread_id, PDO::PARAM_INT);
	    $stmt->execute();
        $this->addThreadLog($thread_id, $_SESSION['id'], '5', '');
    }

    public function setShowInIndex($thread_id){
        $stmt = $this->pdoconnect->prepare('UPDATE `threads` SET 
            `showInIndex` = \'1\', 
            `stickyness` = 2 WHERE `topic_id` = :thread_id');
        $stmt->bindValue(':thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->execute();
        $this->addThreadLog($thread_id, $_SESSION['id'], '4', '');
    }

    public function setHiddeni($thread_id){
        $stmt = $this->pdoconnect->prepare('UPDATE `threads` SET 
            `hiddeni` = \'1\' WHERE `topic_id` = :thread_id');
        $stmt->bindValue(':thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->execute();
        $this->addThreadLog($thread_id, $_SESSION['id'], '6', '');
    }
    public function setHighLightColor($thread_id, $color){
        $stmt = $this->pdoconnect->prepare('UPDATE `threads` SET 
            `highlightcolor` = :color WHERE `topic_id` = :thread_id');
        $stmt->bindValue(':thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->bindValue(':color', $color, PDO::PARAM_STR);
        $stmt->execute();
    }


}

?>