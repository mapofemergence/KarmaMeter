<?php
	require_once("../includes.php");
	require_once("../db_management.php");
	$datas = array();
	$datas['id_creature'] = 1; //balena
	if(isset($_REQUEST['lat'])) $datas['lat'] = $_REQUEST['lat'];
	if(isset($_REQUEST['lon'])) $datas['lon'] = $_REQUEST['lon'];
	if(isset($_REQUEST['id_creature'])) $datas['id_creature'] = $_REQUEST['id_creature'];
	if(isset($_REQUEST['id_user'])) $datas['id_user'] = $_REQUEST['id_user'];
	
	if($datas['lat'] && $datas['lon'] && $datas['id_creature']){
		$query = "INSERT INTO km_user (id, lat, lon, time, id_creature) VALUES ({$datas['id_user']}, {$datas['lat']}, {$datas['lon']}, NULL, {$datas['id_creature']}) ";
		if(insertQuery($query))
			print "ok";
		
	}
	
?>