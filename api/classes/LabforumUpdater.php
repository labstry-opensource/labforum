<?php

class LabforumUpdater
{
    public $pdoconnect;
    public $diff_sql;
    public $upgrade_version;
    public $update_path;
    public $remote_api_path = 'https://www.labstry.com/forum/api/about-labforum.php';

    public function __construct($pdoconnect){
        //if(preg_match('/DROP(\s+)/ig', $diff_sql)) return;  //Abort if DROP exists
        $this->pdoconnect = $pdoconnect;
        $this->update_path = dirname(__FILE__) . '/../updates';
        //$this->diff_sql = $diff_sql;
        //$this->migrate_arr = $migrate_arr;
    }

    public function getCurrentVersion(){
        $stmt = $this->pdoconnect->prepare('SELECT * FROM `laf_settings`');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getServerLatestVersion(){
        return json_decode(file_get_contents($this->remote_api_path));

    }

    public function migrateSchema(){
        if(!$this->diff_sql) return;
        $this->pdoconnect->prepare($this->diff_sql);
        $this->execute();
    }

    public function migrateData(){

    }

}