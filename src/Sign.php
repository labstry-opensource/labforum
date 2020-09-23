<?php

class Sign{
	public $connect;

	public function __construct($connection)
    {
		$this->connection = $connection;
	}

	public function checkIfSigned($id)
    {
        return $this->connection->count('checkin', '*', [
            'id[=]' => $id,
            'checkindate[><]' => [
                date('Y-m-d 00:00:00'),
                date('+1 day', strtotime('Y-m-d 00:00:00')),
            ]
        ]);
	}

	public function checkContinousSign($id)
    {
        return $this->connection->select('continuouscheckin', 'times', [
            'id[=]' => $id,
        ]);
	}
}

?>