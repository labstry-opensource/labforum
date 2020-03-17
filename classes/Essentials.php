<?php


class Essentials
{
    public $meta = array();
    public $module_list = array();
    public $home_url = BASE_URL;
    public $page_title = 'Homepage - Labstry Forum';
    public $opt_in_script;
    public $opt_in_css;
    public $footer_details;

    public function __construct($meta, $module_list = null, $opt_in_script = null, $footer_details = null, $opt_in_css = null)
    {
        $this->meta = $meta;
        $this->module_list = $module_list;
        $this->opt_in_script = $opt_in_script;
        $this->opt_in_css = $opt_in_css;
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
            'opt_in_css' => $this->opt_in_css,
            'title' => $this->page_title,
        );
        $meta = $this->meta;
        $home_url = $this->home_url;
        return include LAF_PATH . '/modules/header.php';
    }
    public function getFooter(){
        $footer_details = $this->footer_details;
        $home_url = $this->home_url;
        return include LAF_PATH . '/modules/footer.php';
    }

    public function imposeRestrictAccess($roles_right, $min_right){
        if($roles_right < $min_right){
            http_response_code(403);
            die('403 Forbidden');
        }
    }

    private function return_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last)
        {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }
    public function max_file_upload_in_bytes() {
        $max_upload = return_bytes(ini_get('upload_max_filesize'));
        $max_post = return_bytes(ini_get('post_max_size'));
        $memory_limit = return_bytes(ini_get('memory_limit'));
        return min($max_upload, $max_post, $memory_limit);
    }
}