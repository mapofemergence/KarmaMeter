<?php
	require_once("includes.php");
	require_once("parser/kml_parser.php");
	require_once("db_management.php");
	
	$coords = kml_parse();
	$start_id = 34672255;
	$limit = 9;
	$query = "INSERT INTO km_user (id, lat, lon) VALUES ";
	foreach($coords as $counter => $c){
		if($counter > $limit){
			break;
		}
		$lat = $c['lat'];
		$lon = $c['lon']; 
		$id = $start_id ++;
		$query .= "( $id, $lat, $lon ),";
	}
	$query = rtrim($query,",");
	print $query;
	$con = dbConnect();
	$result = mysql_query($query, $con) or die (mysql_error());
?>