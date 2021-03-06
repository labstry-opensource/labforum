<?php


class ForumEditValidator
{
    public $apitools;
    public $error_msg;
    public $accepted_types = array('png', 'jpg', 'jpeg');

    public function __construct($apitools)
    {
        $this->apitools = $apitools;
    }
    public function validateImage($file){
        $path = pathinfo($file['forum-hero-image']['name'], PATHINFO_EXTENSION);
        if(!in_array($path, $this->accepted_types)){
            $data['error'] = 'Not an image';
            $this->apitools->outputContent($data);
        }
    }
}