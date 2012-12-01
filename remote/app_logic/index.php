<?php
	require_once("includes.php");
	require_once("header.php");
	
	
?>
<div >

	<a href="javascript:void(0);" id="search_feed">Get a list of feeds in this location (lat, lon): 38.6296007628569, -9.15839530527592</a>
	<br/>
	<a href="javascript:void(0);" id="view_feed">Get the feed n. 63344 data</a>

	<div id="result">Select an option</div>

</div>
<!--script part-->

<script type="text/javascript">
$("#search_feed").click(function(){
	$.post("ajax/cosm_search_feed.php", 
		function(data){$("#result").html(data);}// , "json" 
		);
});
$("#view_feed").click(function(){
	$.post("ajax/cosm_view_feed.php", 
		function(data){$("#result").html(data);}//, "json" 
		);
});
</script>
<?php
require_once("footer.php");
?>