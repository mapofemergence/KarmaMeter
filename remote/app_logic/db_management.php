<?php

require_once("db_info.php");

function dbConnect(){

$con = mysql_connect($dbHost,$dbUser,$dbPassword);
if(!$con){ die('Could not connect: ' . mysql_error()); }

mysql_select_db($dbName,$con);;

echo 'Connected successfully';
return $con;

}

/*
function dbClose($con){
	
}
*/

function dbQuery($q){

	$con = $dbConnect();

	mysql_query($q);
	while($row = mysql_fetch_array()){
		print $row;
	}
	
	mysql_close($con);
}

?>