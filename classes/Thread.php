<?php

class Thread
{

    public $pdoconnect;
    public $forumid;
    public $forumname;

    public $threadid;

    public $threadname;

    public $threadcontent;

    public $author;

    public $topic_creator;

    public $date;

    public $views;

    public $isDraft;

    public $hiddeni;

    public $stickyness;

    public $stickyuntil;

    public $hightlightcolor;

    public $showInIndex;

    public $descript;

    public function __construct($pdoconnect)
    {
        $this->pdoconnect = $pdoconnect;
    }

    public function getStickyThreadId($stickyness)
    {
        $threadid = array();
        $stmt = $this->pdoconnect->prepare("SELECT topic_id FROM threads t WHERE
											draft = 0 AND 
											stickyness = ? AND 
											showInIndex = 1 ORDER BY 
											stickyness DESC,
											topic_name ASC
			");
        $stmt->bindValue(1, $stickyness, PDO::PARAM_INT);

        $stmt->execute();
        $resultsetarr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultsetarr as $resultset) {
            array_push($threadid, $resultset['topic_id']);
        }
        return $threadid;
    }

    public function getHomepageNormalThreadId()
    {
        $threadid = array();
        $stmt = $this->pdoconnect->prepare("SELECT * FROM threads t, subforum s WHERE 
											draft=0 AND stickyness = 0 AND 
											s.fid = t.fid AND 
											showInIndex = 1 
											ORDER BY topic_id DESC");
        $stmt->execute();
        $resultsetarr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultsetarr as $resultset) {
            array_push($threadid, $resultset['topic_id']);
        }
        return $threadid;
    }

    public function getThreadProp($threadid)
    {
        $stmt = $this->pdoconnect->prepare("SELECT * 
			FROM threads t, 
			subforum s, 
			`userspace`.`users` u
			WHERE s.fid = t.fid AND
			u.id = t.author AND
			topic_id = ?");

        $stmt->bindValue(1, $threadid, PDO::PARAM_INT);
        $stmt->execute();
        $threadarr = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->forumid = $threadarr['fid'];
        $this->forumname = $threadarr['fname'];
        $this->threadid = $threadarr['topic_id'];
        $this->threadname = $threadarr['topic_name'];
        $this->threadcontent = $threadarr['topic_content'];
        $this->author = $threadarr['author'];
        $this->topic_creator = $threadarr['username'];
        $this->date = $threadarr['date'];
        $this->highlightcolor = $threadarr['highlightcolor'];
        $this->views = $threadarr['views'];

        // Change to bool
        if ($threadarr['draft'])
            $this->isDraft = true;
        else
            $this->isDraft = false;

        if ($threadarr['hiddeni'])
            $this->hiddeni = true;
        else
            $this->hiddeni = false;

        if ($threadarr['showInIndex'])
            $this->showInIndex = true;
        else
            $this->showInIndex = false;

        $this->stickyness = $threadarr['stickyness'];
        $this->stickyuntil = $threadarr['stickyuntil'];
        $this->hightlightcolor = $threadarr['highlightcolor'];
        $this->descript = $threadarr['seo'];
    }

    public function getReplyCount($threadid)
    {
        $stmt = $this->pdoconnect->prepare("
            SELECT COUNT(*) 'reply_cnt' FROM replies WHERE topic_id = ? GROUP BY topic_id");

        $stmt->bindValue(1, $threadid, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $count['reply_cnt'];
    }
}

?>