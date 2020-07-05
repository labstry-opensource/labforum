<?php

//Deprecation Notice.
// Calling classes file within api folder is deprecated and no longer actively supported
include_once dirname(__FILE__) . '/deprecated.php';

class Maintenance
{
    public $connection;
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    public function checkIfMaintaining(){
        $stmt = $this->connection->prepare("SELECT COUNT(*) 'cnt' FROM laf_maintennance WHERE 
        s_date < NOW() AND e_date > NOW()");
        $stmt->execute();
        $resultset = $stmt->fetch(PDO::FETCH_ASSOC);
        if(isset($resultset['cnt']) && $resultset['cnt'] >= 1 ) return true;
        else return false;
    }
    public function getMinUserRights(){
        $stmt = $this->connection->prepare("SELECT min_right FROM laf_maintenance");
        $stmt->execute();
        $resultset = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultset["min_right"];
    }
    public function getMaintenance(){
        $stmt = $this->connection->prepare("SELECT * FROM maintainance");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function setMaintenance($reason, $from_time, $to_time){

    }

}