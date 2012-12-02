<?php
require_once("../includes.php");
require_once("../parser/feed_searcher.php");
$datas=null;
if(isset($_REQUEST['lat'])) $datas['lat'] = $_REQUEST['lat'];
if(isset($_REQUEST['lon'])) $datas['lon'] = $_REQUEST['lon'];
if(isset($_REQUEST['exposure'])) $datas['exposure'] = $_REQUEST['exposure'];
if(isset($_REQUEST['tag'])) $datas['tag'] = $_REQUEST['tag'];
if(isset($_REQUEST['user'])) $datas['user'] = $_REQUEST['user'];
if(isset($_REQUEST['feed'])){
	$datas['feed'] = $_REQUEST['feed'];
	$cosmos = new PachubeAPI($api_key);
	$json = $cosmos->getFeed("json", $_REQUEST['feed']);
	$parsed_feeds = parse($json);
}else{
	$parsed_feeds = get_feed($datas);
}
if($parsed_feeds) print $parsed_feeds;
?>