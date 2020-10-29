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
        return $this->connection->get('laf_maintenance', 'min_right');
    }
    public function getMaintenance()
    {
        return $this->connection->get('laf_maintenance', '*', [
            'ORDER' => [
                's_date',
                'ASC',
            ]
        ]);
    }
    public function setMaintenance($reason, $from_time, $to_time){

    }
}