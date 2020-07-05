<?php
//Deprecation Notice.
// Calling classes file within api folder is deprecated and no longer actively supported
include_once dirname(__FILE__) . '/deprecated.php';

class ThreadValidator
{
    public $apitools;
    public $forum;
    public $error_msg = array(
        'not_logged_in' => '發帖前必須登入',
        'no_forum_selected' => '請選擇發帖論壇',
        'forum_not_exist' => '選擇的論壇不存在',
        'no_rights' => '你沒有權限在本版發帖',
        'topic_empty' => '帖子內容不能為空白',
        'content_empty' => '帖子主題不能為空白',
        'content_too_short' => '帖子內容必須大於 6 個字符',
        'topic_too_short' => '帖子主題必須大於或等於 2 個字符及少於 30 個字符',
        'read_permission_not_in_range' => '權限必須介乎 0-255 之間',
        'no_rights_to_edit' => '你沒有權限編輯內容',
        'post_empty' => 'Nothing is posted',
    );

    public function __construct($apitools, $forum)
    {
        $this->apitools = $apitools;
        $this->forum = $forum;
    }

    public function validateThread($thread){
        if(empty($thread['thread_content'])){
            $data['error']['thread_content'] = $this->error_msg['content_empty'];
            $this->apitools->outputContent($data);
        }
        if(empty($thread['thread_topic'])){
            $data['error']['thread_topic'] =  $this->error_msg['topic_empty'];
            $this->apitools->outputContent($data);
        }

        $content_word_count = strlen(strip_tags($thread['thread_content']));
        $topic_word_count = str_word_count(strip_tags($thread['thread_topic']));
        if($topic_word_count < 2 && $topic_word_count > 30){
            $data['error']['thread_topic'] =  $this->error_msg['topic_too_short'];
            $this->apitools->outputContent($data);
        }

        if($content_word_count < 6) {
            $data['error']['thread_content'] =  $this->error_msg['content_too_short'];
            $this->apitools->outputContent($data);
        }
    }

    public function validateReply($reply){
        if(empty($reply['reply_content'])){
            $data['error']['reply_content'] = $this->error_msg['content_empty'];
            $this->apitools->outputContent($data);
        }
        $content_word_count = strlen(strip_tags($reply['reply_content']));
        if($content_word_count < 6){
            $data['error']['reply_content'] =  $this->error_msg['content_too_short'];
            $this->apitools->outputContent($data);
        }
    }

    public function validateReadPermission($read_permission){
        if(!isset($read_permission) || !ctype_digit($read_permission) ||
            $read_permission < 0 || $read_permission > 255){
            $data['error']['read_permission'] =  $this->error_msg['read_permission_not_in_range'];
            $this->apitools->outputContent($data);
        }
    }

    public function validateForum($forum_post){
        if(!isset($forum_post)){
            $data['error']['forum'] = $this->error_msg['no_forum_selected'];
            $this->apitools->outputContent($data);
        }
        if(!$this->forum->checkHasForum($forum_post)){
            $data['error']['forum'] = $this->error_msg['forum_not_exist'];
            $this->apitools->outputContent($data);
        }
        return true;
    }

    public function validateAuthorRights($forum_post, $rights){
        if(!$this->forum->hasRightsToAuthorInForum($forum_post, $rights)){
            $data['error']['forum'] = $this->error_msg['no_rights'];
            $this->apitools->outputContent($data);
        }
        return true;
    }

    public function validateEditRights($thread, $roles){
        $hasid = isset($_SESSION['id']);
        $hasRightToEdit = ($roles['r_edit'] === 0) ? false : true;
        $isTheAuthoringUser = ($thread['author'] == $_SESSION['id']) ? true: false;

        if(!$hasid || !$hasRightToEdit || !$isTheAuthoringUser){
            $data['error']['forum'] = $this->error_msg['no_rights_to_edit'];
            $this->apitools->outputContent($data);
        }
        return true;
    }
    public function validateIdentity(){
        if(!isset($_SESSION)) session_start();
        if(!isset($_SESSION['id'])){
            $data['error']['not_logged_in'] = $this->error_msg['not_logged_in'] ;
            $this->apitools->outputContent($data);
        }
    }

    public function validatePostedContent($posted_arr){
        if(empty($posted_arr)){
            $data['error']['post_empty'] = $this->error_msg['post_empty'] ;
            $this->apitools->outputContent($data);
        }
    }

}