<?php
require_once("../includes.php");
require_once("../parser/feed_searcher.php");
//dati di test
//$lat = 38.6296007628569;
//$lon = -9.15839530527592;
//$exposure = "indoor";
$option = false;
$datas = null;
if(isset($_REQUEST['lat'])) $datas['lat'] = $_REQUEST['lat'];
if(isset($_REQUEST['lon'])) $datas['lon'] = $_REQUEST['lon'];
if(isset($_REQUEST['exposure'])) $datas['exposure'] = $_REQUEST['exposure'];
if(isset($_REQUEST['tag'])) $datas['tag'] = $_REQUEST['tag'];
if(isset($_REQUEST['user'])) $datas['user'] = $_REQUEST['user'];
if(isset($_REQUEST['option'])) $option = $_REQUEST['option'];

$parsed_feeds = get_feed($datas);
//$cleaned = hide_empty($parsed_feeds);
//$parsed_feeds = $cleaned;
if(count($parsed_feeds) == 1){
	print json_encode($parsed_feeds);
} else if($option){
	//cleaning data, for html visualisation
	if($parsed_feeds){
		print "<table>";
		print "<tr><td>Useful data</td><td>feed id</td><td>skipped ids</td></tr>";
		foreach($parsed_feeds as $p){
			//$p['data'] = contiene i valori per la lettura
			//$p['skipped'] = contiene i feed non letti dal parser => 'feed_id' è l'id del feed, 'ids' sono gli id non letti
			print "<tr>";
			if(isset($p->data)){
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
			}
		
			print "</tr>";
		}
		print "</table>";
	}
}else print json_encode($parsed_feeds);

	
?>