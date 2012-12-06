<?php
	require_once("../includes.php");
	$api = new Api();
	
	$ret = json_decode($api->get_status("dora", "ciao"));
	
	print $ret->who;
	print "<br>";
	print $ret->what;
	
	
?>