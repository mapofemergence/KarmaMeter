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
	global $parsed_ids;
	$wanted = $parsed_ids;
	$myfeed = array();
	$skipped = array(); //feeds skipped by the parser
	$skip_id = array(); //ids skipped by the parser
	$feed_a = json_decode($feed);
	/*print_r($feed_a);
	print "<br/>";
	print "<br/>";*/
	if($feed_a && isset($feed_a->datastreams)){
		$feed_id = $feed_a->id;
		foreach($feed_a->datastreams as $data){
			$id = $data->id;
			if(in_array(strtolower($id), $wanted)){
				if(isset($feed_a->location->lat))
					$myfeed['lat'] = $feed_a->location->lat;
				if(isset($feed_a->location->lon))
					$myfeed['lon'] = $feed_a->location->lon;
				$myfeed['current_value'] = $data->current_value;
				if(isset($data->unit))
					$myfeed['unit'] = $data->unit;
				if(isset($data->at))
					//date is like "2012-12-02T01:58:19.461164Z"
					//which is y-m-d T H:m:i . Timezone offset in seconds
					//la trasmormo in timestamp
					$date =  $data->at;
					$date = rtrim($date, "Z");
					$timezone_e = explode(".", $date);
					$timezone = $timezone_e[1];
					$time_e = explode("T", $timezone_e[0]);
					$time = explode(":", $time_e[1]);
					$day = explode("-", $time_e[0]);
					$new_date =  mktime($time[0], $time[1], $time[2], $day[1], $day[2], $day[0] );
					
					$myfeed['at'] = $new_date;
			}else{
				$skip_id[] = $id;
			}
		}
		if($feed_id)
			$skipped = array("feed_id"=>$feed_id, "ids"=>$skip_id);
	}
	//print_r($other_ids);
	//if($myfeed){
	return json_encode(array('data'=> $myfeed, "skipped" => $skipped));
	/*	
	}else{
		return json_encode(array("message"=>"nothing to show in here"));
	}*/
}
?>