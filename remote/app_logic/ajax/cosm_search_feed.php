<?php
require_once("../includes.php");
//dati di test
//$lat = 38.6296007628569;
//$lon = -9.15839530527592;
//$exposure = "indoor";
$tag = false;
$locationA = false;
$option = false;
$user = false;
if(isset($_REQUEST['lat'])) $locationA['lat'] = $_REQUEST['lat'];
if(isset($_REQUEST['lon'])) $locationA['lon'] = $_REQUEST['lon'];
if(isset($_REQUEST['exposure'])) $locationA['exposure'] = $_REQUEST['exposure'];
if(isset($_REQUEST['tag'])) $tag = $_REQUEST['tag'];
if(isset($_REQUEST['user'])) $user = $_REQUEST['user'];
if(isset($_REQUEST['option'])) $option = $_REQUEST['option'];

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
if($option){
	//cleaning data, for html visualisation
	if($parsed){
		print "<table>";
		print "<tr><td>Useful data</td><td>feed id</td><td>skipped ids</td></tr>";
		foreach($parsed as $p){
			//$p['data'] = contiene i valori per la lettura
			//$p['skipped'] = contiene i feed non letti dal parser => 'feed_id' è l'id del feed, 'ids' sono gli id non letti
			print "<tr>";
			$data = json_encode($p->data);
			print "<td>$data</td>";
			if(isset($p->skipped)){
				$row = json_encode($p->skipped);
				if(isset($p->skipped->ids)){
					$id = $p->skipped->feed_id;
					//print_r($p->skipped);
					print "<td><a href='$cosm_base_url$id'>$id</a></td>";
				}else print "<td></td>";
				if(isset($p->skipped->ids)){
					$skk = implode(", ", $p->skipped->ids);
					print "<td>{$skk}</td>";
				}else print "<td></td>";
			}
		
			print "</tr>";
		}
		print "</table>";
	}
}else{
	//raw data exit, for processing
	if($parsed) print json_encode($parsed);
}

	
?>