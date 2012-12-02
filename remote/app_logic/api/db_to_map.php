<?php
require_once("../db_management.php");
function parseToXML($htmlStr) { 
	$xmlStr=str_replace('<','&lt;',$htmlStr); 
	$xmlStr=str_replace('>','&gt;',$xmlStr); 
	$xmlStr=str_replace('"','&quot;',$xmlStr); 
	$xmlStr=str_replace("'",'&#39;',$xmlStr); 
	$xmlStr=str_replace("&",'&amp;',$xmlStr); 
	return $xmlStr; 
} 
// Opens a connection to a MySQL server
$connection=dbConnect();
if (!$connection) {
  die('Not connected : ' . mysql_error());
}
// Select all the rows in the markers table
$query = "SELECT * FROM km_user WHERE 1";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'id_user="' . parseToXML($row['id']) . '" ';
  echo 'creature="' . parseToXML($row['id_creature']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lon'] . '" ';
  echo 'time="' . $row['time'] . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';

?>
