<?php
/*parser dei dati
ricavo dai dati provenienti da cosm solo le informazioni che voglio io:
{location: "lat", "lon"}
{datastreams: "at", "current_value"}

*/

$feed = '{"status":"frozen","feed":"https://api.cosm.com/v2/feeds/70314.json","tags":["CO2","power","solar"],"title":"QUT DataTaker","description":"DataTaker feed from Solar Panel on QUT\'s S Block. ","created":"2012-08-07T07:44:07.479747Z","website":"http://www.qut.edu.au","location":{"domain":"physical","disposition":"fixed","ele":"50","lat":-27.477388,"name":"Queensland University of Technology, Brisbane, Queensland, Australia","exposure":"outdoor","lon":153.027186},"version":"1.0.0","creator":"https://cosm.com/users/jameseather","private":"false","updated":"2012-12-01T13:16:03.358383Z","id":70314,"datastreams":[{"tags":["Air Quality","Carbon Dioxide","Environmental","Greenhouse Gas"],"current_value":"1504.712","at":"2012-12-01T13:16:03.110370Z","max_value":"1823.923","unit":{"symbol":"PPM","label":"PPM"},"min_value":"0.702","id":"CO2"},{"tags":["Current","Solar"],"current_value":"67.670","at":"2012-11-17T23:06:05.621159Z","max_value":"278.175","unit":{"symbol":"mA","label":"mA"},"min_value":"-0.11","id":"Current"},{"tags":["Solar"],"current_value":"0.791","at":"2012-11-17T23:06:10.113464Z","max_value":"23.129","unit":{"symbol":"%","label":"%"},"min_value":"-17.969","id":"Efficiency"},{"tags":["Solar"],"current_value":"304.570","at":"2012-11-17T23:06:07.084836Z","max_value":"1415.05","unit":{"symbol":"W/m2","label":"W/m2"},"min_value":"-0.887","id":"Irradiance"},{"tags":["Energy","Solar"],"current_value":"189.245","at":"2012-11-17T23:06:08.629391Z","max_value":"1098.923","unit":{"symbol":"mW","label":"mW"},"min_value":"-0.403","id":"Power"},{"tags":["Environmental"],"current_value":"23.747","at":"2012-11-17T23:06:11.516117Z","max_value":"58.415","unit":{"symbol":"C","label":"C"},"min_value":"9.499","id":"Temperature"},{"tags":["Solar","Voltage"],"current_value":"2.797","at":"2012-11-17T23:06:04.172180Z","max_value":"9.491","unit":{"symbol":"V","label":"V"},"min_value":"1.117","id":"Voltage"}]}';

$wanted = array("co2");
$myfeed = array();
$feed_a = json_decode($feed);
//print_r($feed_a );

if($feed_a){
	$myfeed['lat'] = $feed_a->location->lat;
	$myfeed['lon'] = $feed_a->location->lon;
	foreach($feed_a->datastreams as $data){
		$id = $data->id;
		if(in_array(strtolower($id), $wanted)){
		
			print_r($data);
		}
	}
	//$myfeed[$wanted] = $feed_a->datastreams;
	//$datastreams = $feed_a->datastreams;
	//print_r($location);
	//print_r($datastreams);
}
//print_r($myfeed );

?>