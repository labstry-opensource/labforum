<?php

include_once dirname(__FILE__) . "/AuthorProp.php";

class ThreadOperation{
	public $connection;
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

	public function addThreadLog($thread_id, $user_id, $action, $remarks, $visible = "1"){
        $this->connetion->insert('laf_threads_operation_log', [
            'thread_id' => $thread_id,
            'edit_time' => date('Y-m-d H:i:s'),
            'operator_id' => $user_id,
            'type' => $action,
            'remarks' => $remarks,
            'visible' => $visible,
        ]);
    }

    public function getThreadLog($thread_id){
        return $this->connetion->select('laf_threads_operation_log (l)', [
            '[>]users (u)' => ['l.operator_id' => 'id'],
            '[>]laf_threads_operation_def (d)' => ['l.type' => 'type'],
        ],[
            'l.thread_id', 'l.edit_time' ,
            'l.operator_id', 'l.type', 'l.remarks',
            'l.visible', 'd.description_zh_hk',
            'd.description_eng',
        ],[
            'l.visible[=]' => 1,
            'l.thread_id[=]' => $thread_id,
        ]);
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

	public function postThread($thread)
    {
        $this->connetion->insert('threads',[
            'fid' => $thread['fid'],
            'topic_name' => $thread['thread_topic'],
            'topic_content' => $thread['thread_content'],
            'author' => $thread['author'],
            'date' => date('Y-m-d H:i:s'),
            'draft' => $thread['draft'],
            'rights' =>  $thread['rights'],
            'seo' => $thread['keyword'],
        ]);
        return $this->connetion->id();
    }

    public function postReply($reply)
    {
        $this->connetion->insert('replies', [
            'topic_id' => $reply['thread_id'],
            'reply_id' => ($this->connetion->max('replies',
                'reply_id',  [
                    'topic_id[=]' => $reply['thread_id'],
                ]) + 1),
            'reply_topic' => $reply['reply_topic'],
            'reply_content' => $reply['reply_content'],
            'author' => $_SESSION['id'],
        ]);
        return $this->connetion->id();
    }

    public function editThread($thread)
    {
        $this->connetion->update('threads', [
            'topic_name' => $thread['thread_topic'],
            'topic_content' => $thread['thread_content'],
            'draft' => $thread['draft'],
            'seo' => $thread['keyword'],
            'rights' => $thread['read_permission'],
        ],[
            'topic_id[=]' => $thread['id'],
        ]);

        $this->addThreadLog($thread['id'], $_SESSION['id'], '1', '');

        return true;
    }

    public function moveThreadToForum($thread_id, $fid)
    {
        $this->connetion->update('threads', [
            'fid' => $fid,
        ],[
            'topic_id[=]' => $thread_id,
        ]);
        $this->addThreadLog($thread_id, $_SESSION['id'], '7', '');
    }

    public function promoteThread($thread_id)
    {
        $this->connetion->update('threads', [
            'stickyness' => 1,
        ],[
            'topic_id[=]' => $thread_id,
        ]);
        $this->addThreadLog($thread_id, $_SESSION['id'], '2', '');
    }

    public function demoteThread($thread_id)
    {
        $this->connetion->update('threads', [
           'stickyness' => 0
        ], [
            'topic_id[=]' => $thread_id,
        ]);
        $this->addThreadLog($thread_id, $_SESSION['id'], '3', '');
    }

    public function withdrawnFromIndex($thread_id)
    {
        $this->connetion->update('threads', [
            'showInIndex' => 0,
        ], [
            'topic_id[=]' => $thread_id,
        ]);
        $this->addThreadLog($thread_id, $_SESSION['id'], '5', '');
    }

    public function setShowInIndex($thread_id)
    {
        $this->connetion->update('threads', [
            'showInIndex' => 1,
            'stickyness' => 2,
        ], [
            'topic_id[=]' => $thread_id,
        ]);
        $this->addThreadLog($thread_id, $_SESSION['id'], '4', '');
    }

    public function setHiddeni($thread_id)
    {
        $this->connetion->update('threads', [
            'hiddeni' => 1,
        ], [
            'topic_id[=]' => $thread_id,
        ]);
        $this->addThreadLog($thread_id, $_SESSION['id'], '6', '');
    }

    public function setShowThread($thread_id)
    {
        $this->connection->update('threads', [
            'hiddeni' => 0,
        ], [
            'topic_id[=]' => $thread_id,
        ]);
        $this->addThreadLog($thread_id, $_SESSION['id'], '8', '');
    }

    public function setHighLightColor($thread_id, $color)
    {
        $this->connetion->update('threads', [
            'highlightcolor' => $color,
        ], [
            'topic_id[=]' => $thread_id,
        ]);
    }


}

?>