<?php
require_once("../includes.php");

function get_feed($datas){
	global $api_key;
	
	//dati di test
	//$lat = 38.6296007628569;
	//$lon = -9.15839530527592;
	//$exposure = "indoor";
	$tag = false;
	$locationA = false;
	$option = false;
	$user = false;
	if(isset($datas['lat'])) $locationA['lat'] = $datas['lat'];
	if(isset($datas['lon'])) $locationA['lon'] = $datas['lon'];
	if(isset($datas['exposure'])) $locationA['exposure'] = $datas['exposure'];
	if(isset($datas['tag'])) $tag = $datas['tag'];
	if(isset($datas['user'])) $user = $datas['user'];
	
	// Imposta l'URL e altre opzioni
	$cosmos = new PachubeAPI($api_key);

	$feeds = $cosmos->getFeedsList($format=false, $page=false, $per_page=false, $content=false, $query=false, $tag, $user, $units=false, $status=false, $order=false, $locationA);
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
?>