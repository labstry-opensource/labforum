<?php

class Thread
{
    public $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getStickyThreadId($stickyness)
    {
        return $this->connection->select('threads (t)', [
            '[>]users' => ['user.id' => 't.author'],
            '[>]subforums' => ['subforums.fid', 't.fid']
        ], [
                't.fid' , 't.topic_id', 't.topic_name', 't.topic_content',
                't.author', 't.date', 't.views', 't.draft', 't.hiddeni',
                't.rights', 't.stickyness', 't.stickyuntil', 't.highlightcolor',
                'users.username'
        ], [
            'showInIndex[=]' => 1,
            'draft[=]' => 0,
            'ORDER' => [
                "stickyness" => "DESC",
                "topic_name" => "ASC",
            ]
        ]);
    }

    public function getHomepageNormalThreadId()
    {
        return $this->connection->select('threads (t)', [
            '[>]subforum' => 'fid',
            '[>]users' => ['author', 'id'],
        ], [
            't.fid' , 't.topic_id', 't.topic_name', 't.topic_content',
            't.author', 't.date', 't.views', 't.draft', 't.hiddeni',
            't.rights', 't.stickyness', 't.stickyuntil', 't.highlightcolor', 'subforum.fname (forum_name)',
            'users.username',
        ], [
            'draft[=]' => 0,
            'stickyness[=]' => 0,
            'showInIndex[=]' => 1,
            "ORDER" => [
                'topic_id' => 'DESC'
            ],
        ]);

    }

    public function getThreadProp($threadid)
    {
        $thread_arr =  $this->connection->select('threads', [
            '[>]subforum' => 'fid',
            '[>]user' => ['author' => 'id'],
        ], [
            'threads.fid', 'fname', 'topic_id', 'topic_name', 'topic_content',
            'highlightcolor', 'author', 't.date', 'u.username', 'u.profile_pic',
            't.rights', 't.draft', 't.seo',
        ], [
            'topic_id[=]' => $threadid,
        ]);

        $thread_arr['draft'] = ($thread_arr['draft'] === '0') ? false: true;
        return $thread_arr;
    }

    public function getAuthor($threadid)
    {
        return $this->connection->select('threads' , 'author', [
            'topic_id[=]' => $threadid,
        ]);
    }

    public function getDescription($tid)
    {
        return $this->connection->select('threads', [
            'topic_name', 'seo'
        ], [
            'topic_id[=]' => $tid,
        ]);
    }

    public function getNumberOfReplies($tid)
    {
        return $this->connection->count('replies', '*', [
            'topic_id[=]' => $tid,
        ]);
    }

    public function searchThreadByName($tname, $forum=null, $page=null, $count=null)
    {
        return $this->connection->select('threads', '*', [
            'topic_name[~]' => $tname,
            'ORDER' => [
                'topic_id' => 'DESC',
            ]
        ]);
    }

    public function getThreadsByFid($fid, $from_limit = 0, $page_limit = 10)
    {
        return $this->connection->select('threads', [
            '[>]users' => ['author', 'id'],
        ], [
            't.fid' , 't.topic_id', 't.topic_name', 't.topic_content',
            't.author', 't.date', 't.views', 't.draft', 't.hiddeni',
            't.rights', 't.stickyness', 't.stickyuntil', 't.highlightcolor',
            'u.username'
        ], [
            't.draft[!]' => 1,
            'ORDER' => ['date' => 'DESC'],
            'LIMIT' => [$from_limit, $page_limit],
        ]);
    }

    public function checkHasSuchThread($thread_id)
    {
        return $this->connection->count('threads', '*', [
            'topic_id' => $thread_id,
        ]);
    }

    public function getReplies($thread_id)
    {
        return $this->connection->select('replies', [
            '[>]users' => ['author', 'id'],
        ], [
            'reply_id', 'reply_topic', 'reply_content', 'username',
            'profile_pic', 'author', 'replies.date'
        ], [
            'hiddeni[!]' =>  1,
            'topic_id[=]' => $thread_id,
        ]);
    }

    public function getReplyPropById($thread_id, $reply_id)
    {
        return $this->connection->select('replies', [
            'reply_id', 'reply_topic', 'reply_content',
        ], [
            'topic_id[=]' => $thread_id,
            'reply_id[=]' => $reply_id,
        ]);
    }

    public function addViews($thread_id)
    {
        return $this->connection->update('threads', [
            'views' => ($this->connection->select('threads', 'views', ['topic_id[=]' => $thread_id])) + 1,
        ], [
            'topic_id[=]' => $thread_id,
        ]);

    }

    public function isThreadAuthor($thread_id, $id)
    {
        return $this->connection->count('threads', '*', [
            'topic_id[=]' => $thread_id,
            'author[=]' => $id,
        ]);
    }

    public function checkHasRightToViewThisThread($thread_id, $read_permission)
    {
        return $this->connection->count('threads', '*', [
            'topic_id[=]' => $thread_id,
            'rights[=]' => $read_permission,
        ]);
    }
}

?>