<?php


class Essentials
{
    public $meta = array();
    public $module_list = array();
    public $home_url = '/forum/';
    public $page_title = 'Homepage - Labstry Forum';
    public $opt_in_script;
    public $footer_details;

    public function __construct($meta, $module_list = null, $opt_in_script = null, $footer_details = null)
    {
        $this->meta = $meta;
        $this->module_list = $module_list;
        $this->opt_in_script = $opt_in_script;
        $this->footer_details = $footer_details;
    }

    public function setMeta($text){
        $this->meta = $text;
    }

    public function setTitle($title){
        $this->page_title = $title;
    }

    protected function getMeta(){
        return $this->meta;
    }

    public function getHeader(){
        $optional_paras = array(
            'opt_in_script' => $this->opt_in_script,
            'title' => $this->page_title,
        );
        $meta = $this->meta;
        $home_url = $this->home_url;
        return include dirname(__FILE__) . '/../modules/header.php';
    }
    public function getFooter(){
        $footer_details = $this->footer_details;
        $home_url = $this->home_url;
        return include dirname(__FILE__) . '/../modules/footer.php';
    }
}