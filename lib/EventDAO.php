<?php
class EventDAO{
        private $db;
        public function __construct($db){
	     $this->db = $db;
        }

	/*public function getEventByCity($city){
                        $result = array();
                        $sql = "select * from event where city = :city";
                        $stmt = $this->db->prepare($sql);
			$stmt->bindValue(':city',$city);
			$stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;	
	}*/

	public function getNearbyEvents($location){
                        $result = array();
                        $sql = "select * from events where nearbyLoc = :location";
                        $stmt = $this->db->prepare($sql);
			$stmt->bindValue(':location',$location);
			$stmt->execute();
                        $nearbyEventIds = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $nearbyEventIds;
	}

	public function insertEvent($eventData){
                        $result = array();
                        $sql = "insert into events(url,title,nearbyLoc) values(:url, :title, :location)";
                        $stmt = $this->db->prepare($sql);
			$stmt->bindValue(':url',$eventData['url']);
			$stmt->bindValue(':title',$eventData['title']);
			$stmt->bindValue(':location',$eventData['location']);
			$stmt->execute();
                return $nearbyEventIds;
	}
}
