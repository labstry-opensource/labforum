<?php

//Deprecation Notice.
// Calling classes file within api folder is deprecated and no longer actively supported
include_once dirname(__FILE__) . '/deprecated.php';

class APITools{

    public function outputContent($data){
        header('Content-Type: application/json; charset=utf-8');
        print_r(json_encode($data));
        exit;
    }
    public function imposeLoginRestriction(){
        if(!isset($_SESSION['id'])){

        }
    }
    public function imposeRightRestriction($min_rights, $user_rights){
        if($user_rights < $min_rights){
            http_response_code(403);
            die('403 Forbidden');
        }
    }
}