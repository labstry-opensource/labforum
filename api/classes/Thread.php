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
        $stmt = $this->pdoconnect->prepare("SELECT t.*,
                                            s.fname 'forum_name',
                                            u.username
                                            FROM 
                                            threads t , 
                                            subforum s, 
                                            `userspace`.`users` u WHERE
											draft = 0 AND 
											stickyness = ? AND 
											t.author = u.id AND
											s.fid = t.fid AND
											showInIndex = 1 
                                            ORDER BY 
											stickyness DESC,
											topic_name ASC
			");
        $stmt->bindValue(1, $stickyness, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHomepageNormalThreadId()
    {
        $threadid = array();
        $stmt = $this->pdoconnect->prepare("SELECT t.*, 
                                            s.fname 'forum_name',
                                            u.username,
                                            FROM 
                                            threads t, 
                                            subforum s,  
                                            `userspace`.`users` u
                                            WHERE 
											draft=0 AND stickyness = 0 AND 
											t.author = u.id AND
											s.fid = t.fid AND
											showInIndex = 1 
											ORDER BY topic_id DESC");
        $stmt->execute();
        $resultsetarr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultsetarr;
    }

    public function getThreadProp($threadid)
    {
        $stmt = $this->pdoconnect->prepare("SELECT 
			t.fid, fname, topic_id, topic_name, topic_content, author, t.date, u.username, u.profile_pic, 
			FROM threads t, subforum s, `userspace`.`users` u 
			WHERE s.fid = t.fid AND 
			topic_id = ? AND
			u.id = t.author");
        $stmt->bindValue(1, $threadid, PDO::PARAM_INT);
        $stmt->execute();
        $threadarr = $stmt->fetch(PDO::FETCH_ASSOC);

        /*
         * $this->forumid = $threadarr['fid'];
         * $this->forumname = $threadarr['fname'];
         * $this->threadid = $threadarr['topic_id'];
         * $this->threadname = $threadarr['topic_name'];
         * $this->threadcontent = $threadarr['topic_content'];
         * $this->author = $threadarr['topic_creator'];
         * $this->date = $threadarr['date'];
         * $this->highlightcolor = $threadarr['highlightcolor'];
         * $this->views = $threadarr['views'];
         *
         * //Change to bool
         * if($threadarr['draft']) $this->isDraft = true;
         * else $this->isDraft = false;
         *
         * if($threadarr['hiddeni']) $this->hiddeni = true;
         * else $this->hiddeni = false;
         *
         * if($threadarr['showInIndex']) $this->showInIndex = true;
         * else $this->showInIndex = false;
         *
         * $this->stickyness = $threadarr['stickyness'];
         * $this->stickyuntil = $threadarr['stickyuntil'];
         * $this->hightlightcolor = $threadarr['highlightcolor'];
         * $this->descript = $threadarr['seo'];
         */

        return $threadarr;
    }

    public function getDescription($tid)
    {
        $stmt = $this->pdoconnect->prepare("SELECT seo FROM threads WHERE topic_id = ?");
        $stmt->bindValue(1, $tid, PDO::PARAM_INT);
        $stmt->execute();

        return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    }

    public function getNumberOfReplies($tid)
    {
        $stmt = $this->pdoconnect->prepare("SELECT COUNT(*) 'reply_count' FROM replies WHERE topic_id = ?");
        $stmt->bindValue(1, $tid, PDO::PARAM_INT);
        $stmt->execute();

        $c = $stmt->fetch(PDO::FETCH_ASSOC);

        return $c['reply_count'];
    }

    public function searchThreadByName($tname)
    {
        $stmt = $this->pdoconnect->prepare("SELECT * FROM threads WHERE topic_name LIKE ? ORDER BY topic_id DESC");
        $stmt->bindValue(1, '%' . $tname . '%', PDO::PARAM_STR);
        $stmt->execute();
        return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}

?>