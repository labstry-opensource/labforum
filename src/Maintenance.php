<?php


class Maintenance
{
    public $connection;
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function checkIfMaintaining()
    {
        $counter = $this->connection->count('laf_maintenance', '*',  [
            's_date[<]' => date('Y-m-d H:i:s'),
            'e_date[>]' => date('Y-m-d H:i:s'),
        ]);
        return (isset($counter) && $counter >= 1);
    }
    public function getMinUserRights()
    {
        $stmt = $this->connection->prepare("SELECT min_right FROM laf_maintenance");
        $stmt->execute();
        $resultset = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultset["min_right"];
    }
    public function getMaintenance(){
        $stmt = $this->connection->prepare("SELECT * FROM laf_maintenance");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function setMaintenance($reason, $from_time, $to_time){

    }
}