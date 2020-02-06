<?php

//include_once(dirname(__FILE__)."/classes/Users.php");

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
    
    public function getSpecialTeamRoleById($userid){
        $this->userid = $userid;
        $isSpecialTeam = false;
        
        $stmt = $this->pdoconnect->prepare("SELECT 
                                `roles`.`role_name`,
                                `roles`.`tagcolor`, 
                                `roles`.`rights`
                                
                                FROM `roles`, `specialteam` WHERE
                                `specialteam`.`id` = ? AND 
                                `specialteam`.`role_id` = `roles`.`role_id`
                                ");
        $stmt->bindValue(1, $this->userid, PDO::PARAM_INT);
        $stmt->execute();
        
        if($resultset = $stmt->fetch(PDO::FETCH_ASSOC)){
            $isSpecialTeam = true;
            $this->role_name = $resultset['role_name'];
            $this->tagcolor = $resultset['tagcolor'];
            $this->rights = $resultset['rights'];
        }

        
        return $isSpecialTeam;
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
        
        $this->role_name = $resultset['rname'];
        $this->tagcolor = $resultset['tagcolor'];
        $this->rights = $resultset['read'];
    }

    public function getUserRole($userid){
        if(!$userid){
            $this->role_name = "";
            $this->rights = 0;
        }else{
            if(!$this->getSpecialTeamRoleById($userid))
                $this->getNormalRoleNameById($userid);
        }
       
    }
}


?>
