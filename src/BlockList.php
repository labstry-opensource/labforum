<?php


class BlockList{

	public $connection;

	public function __construct($connection)
    {
		$this->connection = $connection;
	}

	public function getBlockList()
    {
        return $this->connection->select('block_list (b)', [
            '[>]users (u)' => ['userid' => 'id'],
        ], [
            'b.userid', 'u.username', 'b.end_date', 'b.reason',
        ]);

	}

	public function addToBlockList($id, $end_date, $reason)
    {
        return $this->connection->insert('block_list', [
           'userid' => $id,
           'end_date' =>  $end_date,
           'reason' => $reason
        ]);
	}

	public function removeFromBlockList($id)
    {
        return $this->connection->delete('block_list', [
            'userid[=]' => $id,
        ]);
	}

	public function updateBlockedDetails($id, $end_date, $reason)
    {
        return $this->connection->update('block_list', [
            'end_date' => $end_date,
            'reason' => $reason,
        ], [
            'userid[=]' => $id,
        ]);

	}
}
