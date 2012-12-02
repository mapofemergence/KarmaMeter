<?php

// DB

function dbConnect(){
	require_once("db_info.php");
	$con = mysql_connect($dbHost,$dbUser,$dbPassword, true);
	$db = mysql_select_db($dbName,$con);
	if(!$con){ die('Could not connect: ' . mysql_error()); }
	return $con;
}

/*
function dbClose($con){
	
}
*/

function dbQuery($q){
	$con = dbConnect();
	$result = mysql_query($q, $con) or die (mysql_error());
	$result_a = array();
	while($row = mysql_fetch_assoc($result)){
		$result_a[] = $row;
	}
	mysql_close($con);
	return $result_a;
}
function insertQuery($q){
	$con = dbConnect();
	$result = mysql_query($q, $con) or die (mysql_error());
	
	mysql_close($con);
	return $result;
}


// APP SPECIFIC

function populateDb($data){
	$startquery = "INSERT INTO km_enel_record (id, time, type, value, cState) VALUES ";
	$counter=0;
	$query="";
	foreach($data as $d){
		$id = $d['id'];
		$time = $d['time'];
		$obis = $d['type'];
		$val = $d['value'];
		$cs1 = $d['cState'];
		$vals = "($id, '$time', '$obis', $val, $cs1),";
		if(!$counter || $counter>50){
			$query = rtrim($query, ",");
			$query .= ";". $startquery . $vals;
			$counter=0;
		}else
			$query .= $vals;
		$counter++;
		
	}
	$query = ltrim(rtrim($query, ","),";");
	$query .=";";
	return $query;
	
}
?>