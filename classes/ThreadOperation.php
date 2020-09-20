<?php

include_once dirname(__FILE__) ."/AuthorProp.php";

class ThreadOperation{
	public $connetion;
	public $pdotoolkit;
	public $threadid;
	public $replyid;

	//Save rights

	public $r_edit;
	public $r_del;
	public $r_promo;

	public function __construct($connetion, $threadid = null)
    {
		$this->connetion = $connetion;
		$this->threadid = $threadid;
	}

	public function checkRights()
    {
		$id = @$_SESSION['id'];
		$rightarr = $this->connetion->select('roles', [
		    '[>]specialteam' => 'role_id'
        ],[
            'roles.r_edit', 'roles.r_del', 'roles.r_promo',
        ],[
            'specialteam.id' => $id,
        ]);

		$this->r_edit = $rightarr['r_edit'];
		$this->r_del = $rightarr['r_del'];
		$this->r_promo = $rightarr['r_promo'];
	}

	public function deleteThread()
    {

		$this->checkRights();
		$authorprop = new AuthorProp($this->connetion, $this->threadid);

		if($this->r_del || $authorprop->isSessionAuthor())
		{
		    $this->connetion->delete('threads',[
		        'topic_id[=]' => $this->threadid,
            ]);

		    $this->connetion->delete('replies', [
		        'topic_id[=]' => $this->threadid,
            ]);
		}
	}

	public function deleteReply($replyid)
    {
        $this->replyid = $replyid;
		$this->checkRights();
		$authorprop = new AuthorProp($this->connect, $this->threadid);

		if($this->r_del || $authorprop->isSessionAuthor())
		{
			//Deletes reply
            $this->connetion->delete('replies', [
                'topic_id[=]' => $this->threadid,
                'reply_id[=]' => $this->replyid,
            ]);
		}
	}

}

?>