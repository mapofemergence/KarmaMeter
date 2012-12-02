<?php
	require_once("../db_management.php");
	
	//$con = dbConnect();
	$table = "enel_record";
	$fields = array("time", "type", "value", "cState" );
	//aggiungo coordinate gps
	//via della vasca navale gps coordinate
	$limit = null;
	$lat = 41.856349;
	$lon = 12.468886;
	$id = 34672255;
	$filter = null;
	$wanted_fields="";
	$filter="";
	$order="";
	$order_how="";
	if(isset($_REQUEST['filter'])) $filter = $_REQUEST['filter'];
	if(isset($_REQUEST['w_f'])) $wanted_fields = $_REQUEST['w_f'];
	switch($wanted_fields){
		case 'max':
			$wanted_fields = "max(value) as max";
			break;
		case 'min':
			$wanted_fields = "min(value) as min";
			break;
		case 'avg':
			$wanted_fields = "avg(value) as avg";
			break;
		default:
			$wanted_fields = "*";
			break;
	}
	$today = array(date("Y"), date("m"), date("d"));
	switch($filter){
		case 'year':
			$filter = " AND time LIKE '{$today[0]}%' ";
			break;
		case 'month':
			$filter = " AND time LIKE '{$today[0]}/{$today[1]}%' ";
			break;
		case 'day':
			$filter = " AND time LIKE '{$today[0]}/{$today[1]}/{$today[2]}%' ";
			break;
		case 'from':
			if(isset($_REQUEST['from'])) $from = $_REQUEST['from'];
			if(isset($_REQUEST['to'])) $to = $_REQUEST['to'];
			
			$filter = " AND time > '$from%' ";
			if(isset($to)) $filter .= " AND time < '$to%' ";
			break;
		default:
			$filter = "";
			break;
	}
	if(isset($_REQUEST['order'])) $order = $_REQUEST['order'];
	switch($order){
		case 'value':
			$order = " value ";
			break;
		case 'time':
			$order = " time ";
			break;
		default:
			$filter = " time ";
			break;
	}
	
	if(isset($_REQUEST['order_how'])) $order_how = $_REQUEST['order_how'];
	switch($order_how){
		case 'desc':
			$order_how = " DESC ";
			break;
		case 'asc':
			$order_how = " DESC ";
			break;
		default:
			$order_how = " DESC ";
			break;
	}
	
	
	$query = "SELECT $wanted_fields FROM $table WHERE id = $id $filter ";
	if($order)
		$query .= " ORDER BY $order $order_how";
	if($limit)
		$query .= " LIMIT $limit";
	
	print $query;
	print "<br/>";
	$result = dbQuery($query);
	$new_arr = $result;
	if($result && count($result)){
		foreach($result as $id => $res){
			$res['lat'] = $lat;
			$res['lon'] = $lon;
			$new_arr[$id] = $res;
		}
		print json_encode($new_arr);
	}else{
		print "no data";
	}
	
?>