<?php


class UserRoles{
    public $connection;
    
    public $userid;
    public $role_id;
    public $role_name;
    public $tagcolor;
    public $rights;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    
    public function getAllRoles()
    {
        return $this->connection->select('roles', [
            'role_id', 'role_name', 'tagcolor', 'r_edit', 'r_del',
            'r_del', 'r_promo', 'r_hide', 'r_manage', 'profile_invisible',
            'rights'
        ]);
    }

    public function getSpecialTeamRoleById($userid)
    {
        $data = array();

        $this->userid = $userid;
        $isSpecialTeam = false;

        $user_arr =  $this->connection->select('roles', [
            '[>]specialteam' => 'role_id',
        ], [
            'role_id', 'role_name', 'tagcolor', 'r_edit', 'r_del', 'r_promo',
            'r_hide', 'r_manage', 'profile_invisible', 'rights'
        ], [
            'specialteam.id[=]' => $this->userid,
        ]);

        if(empty($user_arr)){
            return;
        }
        $user_arr['type'] = 'SpecialTeam';
        return $user_arr;
    }
    
    public function getNormalRoleNameById($userid){
        $this->userid = $userid;
        $user_arr = $this->connection->select('rank', [
            'rname', 'read', 'tagcolor'
        ], [
            'min_rank[<]' => $this->connection->select('users', 'score', [
                'id[=]' => $userid,
            ])
        ]);
        
        $data["type"] = "Normal";
        $data["role_id"] = "13";
        $data['role_name'] = isset($user_arr["rname"]) ? $user_arr['rname'] : 'Guest';
        $data["tagcolor"] = isset($user_arr["tagcolor"]) ? $user_arr["tagcolor"] : '';
        $data["r_edit"] = 0;
        $data["r_del"] = 0;
        $data["r_promo"] = 0;
        $data["r_hide"] = 0;
        $data["r_manage"] = 0;
        $data["profile_visible"] = 0;   
        $data["rights"] = isset($resultset["read"] ) ? $resultset['read'] : 0;

        return $data;
    }

    public function getUserRole($userid){
        $data = array();
        if($userid === 0){
            $data["type"] = "Guest";
            $data["role_id"] = "0";
            $data['role_name'] = 'Guest';
            $data["tagcolor"] = null;
            $data["r_edit"] = 0;
            $data["r_del"] = 0;
            $data["r_promo"] = 0;
            $data["r_hide"] = 0;
            $data["r_manage"] = 0;
            $data["profile_visible"] = 0;
            $data["rights"] = 0;
        }else{
            $data = $this->getSpecialTeamRoleById($userid);
            if(empty($data["role_name"])){
                $data = $this->getNormalRoleNameById($userid);
            }
        }

        return $data;
    }

    public function showManagingBoard($id)
    {
        return $this->connection->select('laf_moderators (l)', [
            '[>]subforum (s)' => 'fid',
        ], [
            'l.fid', 's.fname'
        ], [
            'moderator_id[=]' => $id,
        ]);
    }
}


?>
