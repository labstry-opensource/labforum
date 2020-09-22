<?php

class Forum{
	public $connection;
	public $fid;
	public $tid;
	public $tname;
	public $tcontent;
	public $author_name;
	public $date;

	public function __construct($connection)
    {
		$this->connection = $connection;
	}

	public function getForumListId()
    {
        return $this->connection->select('laf_forum_listing', 'gid');
	}

	public function getForumName($fid)
    {
        return $this->connection->select('laf_forum_listing', 'gname', [
            'gid[=]' => $fid,
        ]);
	}

	public function getSubforums($gid)
    {
        return $this->connection->select('subforum', '*', [
            'gid[=]' =>  $gid,
            'ORDER' => 'fid',
        ]);
	}

	public function getSubformByFid($fid)
    {
        return $this->connection->get('subforum', '*', [
            'fid[=]' => $fid,
        ]);
    }

	protected function getSubforumViewRights($fid)
    {
        return $this->connection->get('subforum', 'rights', [
            'fid[=]' => $fid,
        ]);
	}

	public function hasRightsToViewForum($fid, $rights)
    {
		$minimumrights = $this->getSubforumViewRights($fid);

		return ($rights >= $minimumrights) ? true: false;
	}

	public function getModerators($fid)
    {
        return $this->connection->select('laf_moderators', [
            '[>]users' => ['moderator_id' => 'id'],
        ], [
            'moderator_id', 'username', 'profile_pic',
        ], [
            'fid[=]' => $fid,
        ]);
    }

    public function addModerator($fid, $userid)
    {
        return $this->connection->insert('laf_moderators', [
            'fid' => $fid,
            'moderator_id' => $userid,
        ]);
    }

    public function isModerator($fid, $userid)
    {
        return $this->connection->count('laf_moderator', '*', [
            'fid[=]' => $fid,
            'moderator_id[=]' => $userid,
        ]);
    }

	public function getSubforumName($fid)
    {
        return $this->connection->get('subforum', 'fname', [
            'fid[=]' => $fid,
        ]);
	}

	public function getThreads($fid)
    {
        return $this->connection->select('thread', 'topic_id', [
            'fid[=]' => $fid,
        ]);
	}
	
	public function getThreadContent($tid)
    {
		$this->tid = $tid;
		return $this->connection->select('thread', [
		    'topic_name', 'topic_content', 'author_name', 'date',
        ], [
            'topic_id[=]' => $tid,
        ]);
	}

	public function countThreads($fid)
    {
        return $this->connection->count('threads', '*' ,  [
            'fid[=]' => $fid,
        ]);
    }

    public function checkHasForum($fid)
    {
        return $this->connection->count('subforum', '*', [
            'fid[=]' => $fid,
        ]);
    }

    public function hasRightsToAuthorInForum($fid, $rights)
    {
	    if($rights === 0) return false;
	    if($rights >= $this->connection->get('subforum', 'min_author_rights', [
	        'fid[=]' => $fid,
        ])){
	        return true;
        }
	    return false;
    }

    public function editForum($forum)
    {
        $this->connection->update('subforum', [
            'rights' => $forum['rights'],
            'rules' => $forum['rules'],
            'forum_banner' => $forum['forum_banner'],
        ], [
            'fid[=]' => $forum['fid'],
        ]);
    }
}