<?php

class Forum{
	public $pdoconnect;
	public $fid;
	public $tid;
	public $tname;
	public $tcontent;
	public $author_name;
	public $date;

	public function __construct($pdoconnect){
		$this->pdoconnect = $pdoconnect;
	}

	public function getForumListId(){
		$stmt = $this->pdoconnect->prepare("SELECT gid FROM forumlist");
		$stmt->execute();

		$gids = array();

		$resultsetarr = $stmt->fetchAll(PDO::FETCH_ASSOC);


		foreach ($resultsetarr as $resultset) {
			array_push($gids, $resultset['gid']);
		}
		return $gids;
	}

	public function getForumName($fid){
		$stmt = $this->pdoconnect->prepare("SELECT gname FROM forumlist WHERE gid = ?");
		$stmt->bindValue(1, $fid, PDO::PARAM_INT);

		$stmt->execute();

		$resultset = $stmt->fetch(PDO::FETCH_ASSOC);

		return $resultset['gname'];
	}

	public function getSubforumIds($gid){
		//Return an array with all the subforum ids
		//Deprecated: It's usage is not guaranteed

		$stmt = $this->pdoconnect->prepare("SELECT fid FROM subforum WHERE gid = ? ORDER BY fid ASC");
		$stmt->bindValue(1, $gid, PDO::PARAM_INT);
		$stmt->execute();

		$resultsetarr = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$fids = array();

		foreach ($resultsetarr as $resultset) {
			array_push($fids, $resultset['fid']);
		}

		return $fids;
	}
	public function getSubforums($gid){
		$stmt = $this->pdoconnect->prepare('SELECT * FROM subforum WHERE gid = ? ORDER BY fid ASC');
		$stmt->bindValue(1, $gid, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	protected function getSubforumViewRights($fid){
		$stmt = $this->pdoconnect->prepare("SELECT rights FROM subforum WHERE fid = ?");
		$stmt->bindValue(1, $fid, PDO::PARAM_INT);

		$stmt->execute();

		$resultset = $stmt->fetch(PDO::FETCH_ASSOC);

		return $resultset['rights'];
	}

	public function hasRightsToViewForum($fid, $rights){
		$minimumrights = $this->getSubforumViewRights($fid);

		return ($rights >= $minimumrights) ? true: false;
	}

	public function getSubforumName($fid){
		$stmt = $this->pdoconnect->prepare("SELECT fname FROM subforum WHERE fid = ?");
		$stmt->bindValue(1, $fid, PDO::PARAM_INT);

		$stmt->execute();

		$resultset = $stmt->fetch(PDO::FETCH_ASSOC);

		return $resultset['fname'];
	}

	public function getThreads($fid){
		$stmt = $this->pdoconnect->prepare("SELECT topic_id FROM thread WHERE fid = ?");
		$stmt->bindValue(1, $fid, PDO::PARAM_INT);
		$stmt->execute();

		$resultsetarr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$tids = array();
		
		foreach($resultsetarr as $resultset){
				array_push($tids, $resultset['topic_id']);
		}
		return $tids;
	}
	
	public function getThreadContent($tid){
		$this->tid = $tid;
		
		$stmt = $this->pdoconnect->prepare("SELECT topic_name, topic_content, author_name, date FROM thread WHERE topic_id = ?");
		$stmt->bindValue(1, $tid, PDO::PARAM_INT);
		$stmt->execute();
		
		$resultset = $stmt->fetch(PDO::FETCH_ASSOC);
		
	}
	public function countThreads($fid){
	    $stmt = $this->pdoconnect->prepare('SELECT COUNT(*) \'count\' FROM threads WHERE fid = :fid');
	    $stmt->bindValue(':fid', $fid, PDO::PARAM_INT);
	    $stmt->execute();
	    return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

}