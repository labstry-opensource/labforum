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
			t.fid, fname, topic_id, topic_name, topic_content, highlightcolor,
			 author, t.date, u.username, u.profile_pic, t.rights, t.draft, t.seo
			FROM threads t, subforum s, `userspace`.`users` u 
			WHERE s.fid = t.fid AND 
			topic_id = ? AND
			u.id = t.author");
        $stmt->bindValue(1, $threadid, PDO::PARAM_INT);
        $stmt->execute();

        $thread_arr = $stmt->fetch(PDO::FETCH_ASSOC);
        $thread_arr['draft'] = ($thread_arr['draft'] === '0') ? false: true;
        return $thread_arr;
    }
    public function getAuthor($threadid){
        $stmt = $this->pdoconnect->prepare("SELECT author FROM threads WHERE topic_id = ?");
        $stmt->bindValue(1, $threadid, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getDescription($tid)
    {
        $stmt = $this->pdoconnect->prepare("SELECT topic_name, seo FROM threads WHERE topic_id = ?");
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
                    u.id = t.author AND 
                    t.draft <> 1 
                    ORDER BY date DESC
                    LIMIT :low_limit, :high_limit');
        $stmt->bindParam(':fid', $fid, PDO::PARAM_INT);
        $stmt->bindParam(':low_limit', $from_limit, PDO::PARAM_INT);
        $stmt->bindParam(':high_limit', $to_limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkHasSuchThread($thread_id){
        $stmt = $this->pdoconnect->prepare('SELECT COUNT(*) \'count\' FROM `threads` WHERE `topic_id` = :id');
        $stmt->bindValue(':id', $thread_id, PDO::PARAM_INT);
        $stmt->execute();

        $number_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        return ($number_count === '0') ? false : true;
    }

    public function getReplies($thread_id){
        $stmt = $this->pdoconnect->prepare('SELECT 
            reply_id, reply_topic, reply_content, u.username, u.profile_pic, author, r.date FROM replies r, `userspace`.`users` u 
            WHERE u.id = r.author AND hiddeni <> 1 AND topic_id = :thread_id');
        $stmt->bindParam(':thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReplyPropById($thread_id, $reply_id){
        $stmt = $this->pdoconnect->prepare('SELECT 
            reply_id, reply_topic, reply_content FROM replies  
            WHERE topic_id = :thread_id AND reply_id = :reply_id');
        $stmt->bindParam(':thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->bindParam(':reply_id', $reply_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addViews($thread_id){
        $stmt = $this->pdoconnect->prepare('
            UPDATE threads SET views = views + 1 WHERE topic_id = :thread_id');

        $stmt->bindParam(':thread_id', $thread_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function isThreadAuthor($thread_id, $id){
        $stmt = $this->pdoconnect->prepare('
            SELECT COUNT(*) \'count\' FROM `threads` WHERE topic_id = :thread_id AND author = :id');
        $stmt->bindParam(":thread_id", $thread_id, PDO::PARAM_INT);
        $stmt->bindParam(":id", $id , PDO::PARAM_INT);
        $stmt->execute();
        return ($stmt->fetch(PDO::FETCH_ASSOC)['count']) ? false: true;
    }

    public function checkHasRightToViewThisThread($thread_id, $read_permission){
        $stmt = $this->pdoconnect->prepare('
            SELECT COUNT(*) \'count\' FROM `threads` WHERE `topic_id` = :id AND `rights` <= :read_permission');
        $stmt->bindParam(":id", $thread_id, PDO::PARAM_INT);
        $stmt->bindParam(":read_permission", $read_permission, PDO::PARAM_INT);
        $stmt->execute();
        return ($stmt->fetch(PDO::FETCH_ASSOC)['count'] === '0' ) ? false: true;
    }
}

?>