<?php
require_once("../includes.php");
function parse_coords($coord){
	/* coordinate approximation to 6 decimals
	* @param float coordinate
	* @return float coordinate
	*/
	return round($coord, 6);
}
function convert_co2($kwh){
	/* unit conversion
	* 1kwh = 400g co2
	*/
	return $kwh*400;
}
function get_feed($datas){
	/* fetch source first in the DB, then if none, into the Cosm feeds 
	* @param array searching keys of feed (i. e. latitude, longitude..)
	* @return array 
	*/
	$db_res = get_feed_from_db($datas);
	if(count($db_res)){
		return $db_res;
	}else{
		return just_one(get_feed_from_cosm($datas));
	}
}
function get_feed_from_db($datas){
	/* fetch into DB to find some useful data 
	* @param array searching keys of feed (i. e. latitude, longitude..)
	* @return array 
	*/
	require_once("../db_management.php");
	
	if(isset($datas['lat']) && $datas['lat']) {
		$conds[] = " lat = " .parse_coords($datas['lat']);
	}
	if(isset($datas['lon']) && $datas['lon']){
		$conds[] = " lon = ". parse_coords($datas['lon']);
	}
	if(isset($datas['user']) && $datas['user']){
		$conds[] = " u.id = ". parse_coords($datas['user']);
	}
	if(isset($conds)){
		$query = "SELECT value FROM km_enel_record as e";
		$query .= " JOIN km_user as u ON u.id = e.id";
		$query .= " WHERE ".implode(" AND ", $conds);
	
		//data DESC e LIMIT 1: prendo l'ultimo valore inserito
		$query .= " ORDER BY e.time DESC LIMIT 1";
		//print $query;
		$new_datas = array();
		$result = dbQuery($query);
		$unit = array("symbol"=>"g","label"=>"grams");
		if($result){
			foreach($result as $re){
				$new_datas[] = array('current_value' => convert_co2($re['value']), 'unit' => $unit);
			}
		}
		$obj = new stdClass(); //generic object
		$obj->data = $new_datas;
		return array(0 => $obj);
	}else return null;
	
}
function get_feed_from_cosm($datas){
	/* fetch into Cosm feeds to find some useful data 
	* @param array searching keys of feed (i. e. tag, user, latitude..)
	* @return array 
	*/
	global $api_key;
	$tag = false;
	$locationA = false;
	$option = false;
	$user = false;
	if(isset($datas['lat']) && $datas['lat']) $locationA['lat'] = $datas['lat'];
	if(isset($datas['lon']) && $datas['lon']) $locationA['lon'] = $datas['lon'];
	if(isset($datas['exposure']) && $datas['exposure']) $locationA['exposure'] = $datas['exposure'];
	if(isset($datas['tag']) && $datas['tag']) $tag = $datas['tag'];
	if(isset($datas['user']) && $datas['user']) $user = $datas['user'];
	if(isset($datas['feed']) && $datas['feed']) $feed = $datas['feed'];
	
	// Imposta l'URL e altre opzioni
	$cosmos = new PachubeAPI($api_key);

	$feeds = $cosmos->getFeedsList($format=false, $page=false, $per_page=false, 
					$content=false, $query=false, $tag, $user, $units=false, 
					$status=false, $order=false, $locationA);
	$feeds_a = json_decode($feeds, true);
	$parsed = false;
	foreach($feeds_a as $f ){
		if($f and is_array($f)){
			foreach($f as $stream){
				$pars = json_decode(parse(json_encode($stream), false));
				if($pars && !isset($pars->message)){
					$parsed[] = $pars;
				}
			}
		}
	}
	if($parsed) return $parsed;
	else return null;
}
function hide_empty($feed_a){
	/* clean the results of get_feed_from_cosm by deleting all emtpy datas 
	* @param array the list of data you want to clean 
	* @return array 
	*/
	$clean = array();
	foreach($feed_a as $feed){
		if(isset($feed->data) && ($feed->data)){
			$clean[] = $feed;
		}
	}
	if($clean) return $clean;
}		
function just_one($feeds){
	/*from a list of feeds, pick just one based on last date
	* @param array the list of data you want to clean 
	* @return array
	*/
	$last = null;
	$last_date = 0;
	foreach($feeds as $feed){
		if(isset($feed->data) && $feed->data && isset($feed->data->at) && $feed->data->at){
			
			if( $feed->data->at > $last_date){
				//print $feed->data->at;
				$last = $feed;
				
			}
		}
	}
	return $last;
}
?>