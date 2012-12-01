<?php
require_once("../includes.php");
// Imposta l'URL e altre opzioni
$cosmos = new PachubeAPI($api_key);
$locationA = array("lat"=>38.6296007628569, "lon"=>-9.15839530527592, "exposure"=>"indoor");
$feeds = $cosmos->getFeedsList($format=false, $page=false, $per_page=false, $content=false, $query=false, $tag=false, $user=false, $units=false, $status=false, $order=false, $locationA);
$feeds_a = json_decode($feeds, true);
foreach($feeds_a as $f ){
	if($f and is_array($f)){
		print json_encode($f);
	}
}
	
	
?>