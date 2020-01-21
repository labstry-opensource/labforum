<?php

class Thread
{
    public $pdoconnect;

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
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function getThreadsByFid($fid, $from_limit = 0, $to_limit = 10){
        $stmt = $this->pdoconnect->prepare('SELECT t.*, u.`username` AS username FROM 
                    threads t, `userspace`.`users` u WHERE 
                    fid = :fid AND 
                    u.id = t.author 
                    ORDER BY date DESC
                    LIMIT :low_limit, :high_limit');
        $stmt->bindParam(':fid', $fid, PDO::PARAM_INT);
        $stmt->bindParam(':low_limit', $from_limit, PDO::PARAM_INT);
        $stmt->bindParam(':high_limit', $to_limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>