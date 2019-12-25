<?php

include_once "connect.php";

class UserRoles{
    public $pdoconnect;
    
    public $userid;
    public $role_id;
    public $role_name;
    public $tagcolor;
    public $rights;
    
    public function __construct($pdoconnect){
        $this->pdoconnect = $pdoconnect;
    
    }
    
    public function getAllRoles(){
        $stmt = $this->pdoconnect->prepare("SELECT `roles`.`role_id`, 
            `roles`.`role_name`,
            `roles`.`tagcolor`,
            `roles`.`r_edit`,
            `roles`.`r_del`,
            `roles`.`r_promo`,
            `roles`.`r_hide`,
            `roles`.`r_manage`,
            `roles`.`profile_invisible`,
            `roles`.`rights`
            FROM `roles`");
        $stmt->execute();

        $roles_arr = array();

        while($resultset = $stmt->fetch(PDO::FETCH_ASSOC)){
            $props = array();
            $props["role_id"] = $resultset["role_id"];
            $props["role_name"] = $resultset["role_name"];
            $props["tagcolor"] = $resultset["tagcolor"];
            $props["r_edit"] = $resultset["r_edit"];
            $props["r_del"] = $resultset["r_del"];
            $props["r_promo"] = $resultset["r_promo"];
            $props["r_hide"] = $resultset["r_hide"];
            $props["r_manage"] = $resultset["r_manage"];
            $props["profile_invisible"] = $resultset["profile_invisible"];   
            $props["tagcolor"] = $resultset["tagcolor"];
            $props["rights"] = $resultset["rights"];

            array_push($roles_arr, $props);
        }

        return $roles_arr;
    }

    public function getSpecialTeamRoleById($userid){
        $data = array();

        $this->userid = $userid;
        $isSpecialTeam = false;
        
        $stmt = $this->pdoconnect->prepare("SELECT 
            `roles`.`role_id`,
            `roles`.`role_name`,
            `roles`.`tagcolor`, 
            `roles`.`r_edit`,
            `roles`.`r_del`,
            `roles`.`r_promo`,
            `roles`.`r_hide`,
            `roles`.`r_manage`,
            `roles`.`profile_invisible`,
            `roles`.`rights`
                                
            FROM `roles`, `specialteam` WHERE
            `specialteam`.`id` = ? AND 
            `specialteam`.`role_id` = `roles`.`role_id`
                                ");
        $stmt->bindValue(1, $this->userid, PDO::PARAM_INT);
        $stmt->execute();
        
        if($resultset = $stmt->fetch(PDO::FETCH_ASSOC))
            $isSpecialTeam = true;

        $data["type"] = "SpecialTeam";
        $data["role_id"] = $resultset["role_id"];
        $data['role_name'] = $resultset["role_name"];
        $data["tagcolor"] = $resultset["tagcolor"];
        $data["r_edit"] = $resultset["r_edit"];
        $data["r_del"] = $resultset["r_del"];
        $data["r_promo"] = $resultset["r_promo"];
        $data["r_hide"] = $resultset["r_hide"];
        $data["r_manage"] = $resultset["r_manage"];
        $data["profile_invisible"] = $resultset["profile_invisible"];   
        $data["tagcolor"] = $resultset["tagcolor"];
        
        $data["rights"] = $resultset["rights"];

        
        return $data;
    }
    
    public function getNormalRoleNameById($userid){
        $this->userid = $userid;
    
        $stmt = $this->pdoconnect->prepare("
			SELECT `rank`.rname, `rank`.read, `rank`.tagcolor
			FROM `rank` WHERE `rank`.`min_mark` < 
				(SELECT `userspace`.`users`.`score` 
				FROM `userspace`.`users` 
				WHERE `userspace`.`users`.`id` = ? )
        ");
        
        $stmt->bindValue(1, $this->userid, PDO::PARAM_INT);
        $stmt->execute();
        
        $resultset = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $data["type"] = "Normal";
        $data["role_id"] = "13";
        $data['role_name'] = $resultset["rname"];
        $data["tagcolor"] = $resultset["tagcolor"];
        $data["r_edit"] = 0;
        $data["r_del"] = 0;
        $data["r_promo"] = 0;
        $data["r_hide"] = 0;
        $data["r_manage"] = 0;
        $data["profile_visible"] = 0;   
        $data["rights"] = $resultset["read"];

        return $data;
    }

    public function getUserRole($userid){
        $data = array();
        $data = $this->getSpecialTeamRoleById($userid);
        if($data["role_name"] == NULL){
            $data = $this->getNormalRoleNameById($userid);
        }
        return $data;
    }
}


?>
