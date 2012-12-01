<?php
/*
* parser dei dati
* ricavo dai dati provenienti da cosm solo le informazioni che voglio io:
* {location: "lat", "lon"}
* {datastreams: "at", "current_value"}
**
* @param string $feed (risultato json)
* @return string (parsed json)
*/
function parse($feed){
	$wanted = array("co2");
	$myfeed = array();
	$feed_a = json_decode($feed);
	//print_r($feed_a);
	if($feed_a){
		foreach($feed_a->datastreams as $data){
			$id = $data->id;
			if(in_array(strtolower($id), $wanted)){
				$myfeed['lat'] = $feed_a->location->lat;
				$myfeed['lon'] = $feed_a->location->lon;
				$myfeed['current_value'] = $data->current_value;
			}
		}
	}
	if($myfeed)
		return json_encode($myfeed);
	else{
		return json_encode(array("message"=>"nothing to show in here"));
	}
}
?>