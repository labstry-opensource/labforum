<?php

//Deprecation Notice.
// Calling classes file within api folder is deprecated and no longer actively supported
include_once dirname(__FILE__) . '/deprecated.php';

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
        return json_decode(file_get_contents($this->remote_api_path), true);
    }

    public function checkUpdate(){
        $current_version_data = $this->getCurrentVersion();
        $remote_version_data = $this->getServerLatestVersion();

        $remote_date_time = strtotime($remote_version_data['laf_version']);
        $current_date_time = strtotime($current_version_data['laf_version']);

        if($remote_date_time > $current_date_time){
            $data['data'] = array(
                'program_updatable' => true,
                'version' => $remote_version_data['laf_version'],
                'release_date' => $remote_version_data['laf_release_date'],
                'db_version' => $remote_version_data['db_version'],
            );
        }else{
            $data['data'] = array(
                'program_updatable' => false,
                'version' => $current_version_data['laf_version'],
                'release_date' => $current_version_data['laf_release_date'],
                'db_version' => $current_version_data['db_version'],
            );
        }
        return $data;
    }

    public function migrateSchema(){
        if(!$this->diff_sql) return;
        $this->pdoconnect->prepare($this->diff_sql);
        $this->execute();
    }

    public function migrateData(){

    }

}