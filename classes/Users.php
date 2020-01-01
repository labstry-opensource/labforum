<?php

class Users{
    public  $pdoconnect;
    public  $pdotoolkit;
    
    public  $userid;
    public  $username;
    private $password;      //Password should be private
    public  $email;
    public  $regdate;
    public  $replies;
    public  $score;
    public  $topics;
    public  $profilepic;
    public  $isemailvis;
    public  $isspecialteam;
    public  $password_hint;
    public  $password_hint_answer;
    public  $rname;
    public  $usercounter;
    
    public function __construct($pdoconnect, $pdotoolkit){
        $this->pdoconnect = $pdoconnect;
        $this->pdotoolkit = $pdotoolkit;
    }
    public function getUserPropById($userid){
        //Check database
        $this->userid = $userid;
        $stmt = $this->pdoconnect->prepare("SELECT * FROM `userspace`.users WHERE id= ?");
        $stmt->bindValue(1, $userid, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->username = $result['username'];
        $this->password = $result['password'];
        $this->email = $result['email'];
        $this->regdate = $result['date'];
        $this->replies = $result['replies'];
        $this->score = $result['score'];
        $this->topics = $result['topics'];
        $this->profilepic = $result['profile_pic'];
        $this->isemailvis = $result['email_visible'];
        $this->isspecialteam = $result['s_team'];
        $this->password_hint = $result['password_hint'];
        $this->password_hint_answer = $result['password_hint_answer'];
        $this->rname = $result['rname'];
    }
    public function getUserPropByUname($username){
        //Check database
        $this->username = $username;
        $stmt = $this->pdoconnect->prepare("SELECT * FROM `userspace`.users WHERE username= ?");
        $stmt->bindValue(1, $username, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->id = $result['id'];
        $this->password = $result['password'];
        $this->email = $result['email'];
        $this->regdate = $result['date'];
        $this->replies = $result['replies'];
        $this->score = $result['score'];
        $this->topics = $result['topics'];
        $this->profilepic = $result['profile_pic'];
        $this->isemailvis = $result['email_visible'];
        $this->isspecialteam = $result['s_team'];
        $this->password_hint = $result['password_hint'];
        $this->password_hint_answer = $result['password_hint_answer'];
        $this->rname = $result['rname'];
    }
    public function getUserPropByEmail($email){
        //Check database
        $this->email = $email;
        $stmt = $this->pdoconnect->prepare("SELECT * FROM `userspace`.users WHERE email= ?");
        $stmt->bindValue(1, $this->email, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->username = $result['username'];
        $this->password = $result['password'];
        $this->id = $result['id'];
        $this->regdate = $result['date'];
        $this->replies = $result['replies'];
        $this->score = $result['score'];
        $this->topics = $result['topics'];
        $this->profilepic = $result['profile_pic'];
        $this->isemailvis = $result['email_visible'];
        $this->isspecialteam = $result['s_team'];
        $this->password_hint = $result['password_hint'];
        $this->password_hint_answer = $result['password_hint_answer'];
        $this->rname = $result['rname'];
    }
    
    public function getUsername(){
        return $this->username;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getProfilePath(){
        return $this->profilepic;
    }
    public function getNewestUser(){
        //Getting the new user and current user count
        $stmt = $this->pdoconnect->prepare("SELECT * FROM `userspace`.users ORDER BY id DESC");
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->username = $user['username'];
        $this->userid = $user['id'];
    }
    public function getUserCount(){
        $stmt = $this->pdoconnect->query("SELECT COUNT(*) FROM `userspace`.users")->fetch(PDO::FETCH_ASSOC);
        return $stmt['COUNT(*)'];
    }
    public function isUsernameExists($uname){
        $stmt = $this->pdoconnect->prepare("SELECT COUNT(*) FROM `userspace`.users WHERE username=?");
        $stmt->bindValue(1, $uname, PDO::PARAM_STR);
        $stmt->execute();
        return ($stmt->fetchColumn() > 0) ? true: false;
    }
    public function isEmailValid($email){
        $stmt = $this->pdoconnect->prepare("SELECT COUNT(*) FROM `userspace`.users WHERE email=?");
        $stmt->bindValue(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        return ($stmt->fetchColumn() > 0) ? true: false;
    }
}

?>
