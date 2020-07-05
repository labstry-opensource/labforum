<?php


class BlockList{

	public $pdoconnect;

	public function __construct($pdoconnect){
		$this->pdoconnect = $pdoconnect;
	}

	public function getBlockList(){
		$stmt = $this->pdoconnect->prepare("SELECT 
			`php_forum`.`block_list`.`userid`,
			`userspace`.`users`.`username`, 
			`php_forum`.`block_list`.`end_date`,
			`php_forum`.`block_list`.`reason`

			FROM `php_forum`.`block_list`, 
			`userspace`.`users` WHERE 
			`userspace`.`users`.`id` = `php_forum`.`block_list`.`userid`
			");

		$stmt->execute();
		$resultset= $stmt->fetch(PDO::FETCH_ASSOC);

		return $resultset;
	}


	public function addToBlockList($id, $end_date, $reason){
		$stmt = $this->pdoconnect->prepare("INSERT INTO `php_forum`.`block_list` 
			VALUES (? ,? ,? )
		");
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$stmt->bindValue(2, $end_date, PDO::PARAM_STR);
		$stmt->bindValue(3, $reason, PDO::PARAM_STR);
		$stmt->execute();


		return 1;
	}

	public function removeFromBlockList($id){
		$stmt = $this->pdoconnect->prepare("DELETE FROM `php_forum`.`block_list` WHERE userid = ?");
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$stmt->execute();

		print_r($stmt->errorInfo());

		return 1;
	}

	public function updateBlockedDetails($id, $end_date, $reason){
		$stmt = $this->pdoconnect->prepare("UPDATE `php_forum`.`block_list` SET 
			end_date = ?, 
			reason = ? WHERE userid = ?
			");

		$stmt->bindValue(1, $end_date, PDO::PARAM_STR);
		$stmt->bindValue(2, $reason, PDO::PARAM_STR);
		$stmt->bindValue(3, $id, PDO::PARAM_INT);

		$stmt->execute();
		
		print_r($stmt->errorInfo());

		return 1;

	}
}
