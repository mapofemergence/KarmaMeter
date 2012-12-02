<?php
function kml_parse(){
	$kml_file = dirname(__FILE__)."/spaceinvaders_map.xml";
	$xml = simplexml_load_file($kml_file);
	$doc = $xml->Document;
	$coords = array();
	foreach($doc->Placemark as $place){
		$coo = ($place->Point->coordinates);
		list($long, $lat)= explode(",",$coo);
		$coords[] = array("lon"=>$long, "lat"=>$lat);
	}
	return $coords;
}
?>