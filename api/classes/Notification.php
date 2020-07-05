<?php
//Deprecation Notice.
// Calling classes file within api folder is deprecated and no longer actively supported
include_once dirname(__FILE__) . '/deprecated.php';

include ("third-party/xmldb.php");

class Notification{
	public $notifier;
	public $recepient;
	public $notify_content;
	
	public function __construct($notifier){
		$this->notifier = $notifier;
		//Connect or create a database
		$db = xmlDb::connect($this->notifier);
	}
	
}

?>
