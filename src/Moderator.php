<?php

class Moderator{
    public $pdoconnect;

    public function __construct($pdoconnect)
    {
        $this->pdoconnect = $pdoconnect;
    }
    public function isUserForumModerator($user_id, $fid){
        $stmt = $this->pdoconnect->prepare('SELECT COUNT(*) AS `record_count`
FROM laf_moderators
WHERE fid = :fid
AND moderator_id = :userid');
        $stmt->bindParam(':fid', $fid, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return ($stmt->fetch(PDO::FETCH_ASSOC)['record_count'] > 0);
    }
}