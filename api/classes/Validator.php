<?php
//Deprecation Notice.
// Calling classes file within api folder is deprecated and no longer actively supported
include_once dirname(__FILE__) . '/deprecated.php';

class Validator{
    public $error_msg;
    public $apitools;

    public function __construct($apitools)
    {
        $this->apitools = $apitools;
        $this->error_msg = include_once LAF_ROOT_PATH . '/locale/' . LANGUAGE .'/class/validator.php';
    }

    public function validateLoggedIn($session = null){
        if(isset($session)) return;
        $data['error'] = $this->error_msg['not_logged_in'];
        $this->apitools->outputContent($data);
    }

    public function validateAdmin($rights){
        if($rights > 254) return;
        $data["error"] = $this->error_msg['not_admin'];
        $this->apitools->outputContent($data);
    }

    public function validatePassword($user_arr, $password, $repassword){
        if(empty($password) || empty($repassword)){
            $data["error"]['password'] = '';
            $data["error"]['repassword'] = $this->error_msg['password_empty'];
            $this->apitools->outputContent($data);
        }
        if($password !== $repassword){
            $data["error"]['password'] = '';
            $data['error']['repassword'] = $this->error_msg['password_doesnt_match'];
            $this->apitools->outputContent($data);
        }
        if(!password_verify($password, $user_arr['password'])){
            $data["error"]['password'] = $this->error_msg['password_incorrect'];
            $this->apitools->outputContent($data);
        }
    }

}