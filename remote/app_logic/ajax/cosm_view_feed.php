<?php
require_once("../includes.php");

if(isset($_REQUEST['lat'])) $lat = $_REQUEST['lat'];
if(isset($_REQUEST['lon'])) $lon = $_REQUEST['lon'];

//$feed = 70314; //co2 da un'università in australia
if(isset($_REQUEST['feed'])) $feed = $_REQUEST['feed'];
// Imposta l'URL e altre opzioni
$cosmos = new PachubeAPI($api_key);
$json = $cosmos->getFeed("json", $feed);
$json = parse($json);
print $json;


?>