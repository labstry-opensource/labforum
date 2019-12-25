<?php


class Essentials
{
    public $meta = array();
    public $module_list = array();
    public $home_url = '/forum';

    public function __construct($meta, $module_list = null)
    {
        $this->meta = $meta;
        $this->module_list = $module_list;
    }

    public function setMeta($text){
        $this->meta = $text;
    }

    protected function getMeta(){
        return $this->meta;
    }

    public function getHeader(){
        $meta = $this->meta;
        $home_url = $this->home_url;
        return include dirname(__FILE__)."/../views/header.php";
    }
}