<?php

class EventManager{
	private $eb_client;
	public function __construct(){
		$authentication_tokens = array(
				'app_key'  => '4MC4C4NOAUURWIUXWY',
				'user_key' => '138674141383322641263');
		$this->eb_client = new Eventbrite( $authentication_tokens );
	}


	public function getEvents($search_param){
		$city = $search_param['city'];
		$location = $search_param['loc'];
		$eventDao = EventDAOFactory::getInstance()->createDAO('test_db');
	       		
		$eventDataArr = $eventDao->getNearbyEvents($location);	
		if(empty($eventDataArr)){
			$search_params = array(
				'longitude' => $search_param['long'],
				'latitude' => $search_param['lat'],
				'within' => 5,
				);
			$response = $this->eb_client->event_search( $search_params );
			for($i = 1;$i < count($response->events);$i++){
				
				$eventDataArr[$i-1]['url'] = $response->events[$i]->event->url;	
				$eventDataArr[$i-1]['title'] = $response->events[$i]->event->title;
				$eventDataArr[$i-1]['location'] = $location;
					
			}
			foreach($eventDataArr as $eventData){
				$eventDao->insertEvent($eventData);
			}
			
			
		}
		return $eventDataArr;

	}

	private function distance($lat1, $lon1, $lat2, $lon2, $unit) {

		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}

}
?>
