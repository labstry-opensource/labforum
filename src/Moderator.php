<?php

class Moderator{
    public $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    public function isUserForumModerator($user_id, $fid)
    {
        return $this->connection->count('laf_moderators', '*', [
            'fid[=]' => $fid,
            'moderator_id[=]' => $user_id,
        ]);
    }
}