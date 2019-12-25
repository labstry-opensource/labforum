<?php

class Sign{
	public $pdoconnect;

	public function __construct($pdoconnect){
		$this->pdoconnect = $pdoconnect;
	}

	public function checkIfSigned($id){
		$stmt = $this->pdoconnect->prepare("SELECT COUNT(*) 'cnt' FROM checkin WHERE id = ? AND DATE(checkindate) = DATE(NOW())");
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$stmt->execute();

		$resultset = $stmt->fetch(PDO::FETCH_ASSOC);

		return ($resultset['cnt'] == 0) ? false : true;
	}

	public function checkContinousSign($id){
		$stmt = $this->pdoconnect->prepare("SELECT times FROM continuouscheckin WHERE id= ?");
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$stmt->execute();
	
		$resultset = $stmt->fetch(PDO::FETCH_ASSOC);

		return $resultset['times'];
	}
}

?>