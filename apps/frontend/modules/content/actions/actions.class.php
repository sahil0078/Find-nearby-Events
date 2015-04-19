<?php

/**
 * content actions.
 *
 * @package    p2
 * @subpackage content
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contentActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    	
	//$this->forward('default', 'module');
  }

  public function executeGetEvent(sfWebRequest $request)
  {
	try{
	if(empty($request->getParameter('lat'))){
	
		$geoIpLoc = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));	
		$search_param['city'] = $geoIpLoc['geoplugin_city'];
		$search_param['loc'] = $geoIpLoc['geoplugin_region'];
		$search_param['lat'] = $geoIpLoc['geoplugin_latitude'];
		$search_param['long'] = $geoIpLoc['geoplugin_longitude'];
	}else{
		$search_param['city'] = $request->getParameter('city');
		$search_param['loc'] = $request->getParameter('loc');
		$search_param['lat'] = $request->getParameter('lat');
		$search_param['long'] = $request->getParameter('long');
	}
	$eventManager = new EventManager();
	$events = $eventManager->getEvents($search_param);	
	}catch(Exception  $e){
               file_put_contents('/tmp/error',$e,FILE_APPEND);
		//         echo $e->getMessage();die;
	}	
	return $this->renderText(json_encode($events));
    	//return sfViw::NONE;
	//$this->forward('default', 'module');
  }
}
