<?php

require_once("db_info.php");


// DB

function dbConnect(){
	
	global $dbHost,$dbUser,$dbPassword, $dbName;
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


// APP SPECIFIC

function populateDb($data){
	// $query = "SELECT id, time, obis, value, cs1 FROM record WHERE  id = 82042768 and not id = (select movieboard from MvMonitor where seq = '093')";
	foreach($data as $d){
		$id = $d['id'];
		$time = $d['time'];
		$obis = $d['type'];
		$val = $d['value'];
		$cs1 = $d['cState'];
		$query = "INSERT INTO record (id, time, obis, value, cs1) VALUES ($id, '$time', '$obis', $val, $cs1)";
		print $query.'<br/>';
		//dbQuery($query);
	}
}

?>