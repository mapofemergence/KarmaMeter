<?php
	require_once("includes.php");
	require_once("header.php");
	
	
?>
<div >
	<form method="post" action="javascript:void(0)">
	<fieldset>
		<label> longitude</label>
		<input type="text" name="lon"/>
		<label> latitude</label>
		<input type="text" name="lat"/>
		<label> tag</label>
		<input type="text" name="tag"/>
		<label> user</label>
		<input type="text" name="user" value="chudichudi"/>
		<input type="hidden" name="option" value="clean"/>
		<a href="javascript:void(0);" id="search_feed">Get a list of feeds in this location</a>
	</fieldset>	
	</form>
	<hr/>
	<br/>
	<form method="post" action="javascript:void(0)">
	<fieldset>
		<label>feed id</label>
		<input type="text" name="feed" value="70314"/>
		<input type="hidden" name="option" value="clean"/>
		<a href="javascript:void(0);" id="view_feed">Get the feed data</a>
	</fieldset>	
	</form>
	<hr/>
	<br/>

	<form method="post" action="javascript:void(0)">
	<fieldset>
		<div class="radio">
			<label>wanted fields</label>
			<input id="w_f1" type="radio" name="w_f" value="all"><label for="w_f1">all</label>
			<input id="w_f2" type="radio" name="w_f" value="max"><label for="w_f2">max</label>
			<input id="w_f3" type="radio" name="w_f" value="min"><label for="w_f3">min</label>
			<input id="w_f4" type="radio" name="w_f" value="avg"><label for="w_f4">average</label>
		</div>
		<div class="radio">
			<label>filter</label>
			<input id="date1" type="radio" name="fil" class="filter" value="always"><label for="date1">always</label>
			<input id="date2" type="radio" name="fil" class="filter" value="year"><label for="date2">current year</label>
			<input id="date3" type="radio" name="fil" class="filter" value="month"><label for="date3">current month</label>
			<input id="date4" type="radio" name="fil" class="filter" value="day"><label for="date4">today</label>
			<input id="filter" type="text" name="filter" value=""/>
		</div>
		<div>
			<label for="from">from</label><input type="text" id="from" name="from" class="datepicker" value="" />
			<label for="to">to</label><input type="text" id="to" name="to" class="datepicker" value="" />
		</div>
		<div class="radio">
			<label>order</label>
			<input id="order1" type="radio" name="order" value="time"><label for="order1">by date </label>
			<input id="order2" type="radio" name="order" value="value"><label for="order2">by value</label>
		</div>
		<div class="radio">
			<label>asc-desc</label>
			<input id="order_how1" type="radio" name="order_how" value="desc"><label for="order_how1">descending</label>
			<input id="order_how2" type="radio" name="order_how" value="asc"><label for="order_how2">ascending</label> 
		</div>
		<input type="hidden" name="option" value="clean"/>
		<a href="javascript:void(0);" id="view_db">Get from Enel SmartMeter dataset on db</a>
	</fieldset>	
	</form>
	
	<h2>Results</h2>
	<div id="result">Select an option</div>

</div>
<!--script part-->
<script type="text/javascript">
//date picker
$(".radio").buttonset();
//al click su uno dei pulsanti per il filtro della data
//riempio il campo nascosto chiamato "filter"
$(".filter").change(function(){
	$("#filter").val($(this).val());
})
$("#from").datepicker({
	defaultDate: "+1w",
	dateFormat: "yy/mm/dd",
	changeMonth: true,
	onClose: function( selectedDate ) {
		$("#to").datepicker( "option", "minDate", selectedDate );
		$("#filter").val("from");
		$(".filter").prop("checked", false);
	}
});
$("#to").datepicker({
	defaultDate: "+1w",
	dateFormat: "yy/mm/dd",
	changeMonth: true,
	onClose: function( selectedDate ) {
		$( "#from" ).datepicker( "option", "maxDate", selectedDate );
	}
});
		
$("#search_feed").click(function(){
	postdata = $(this).parent().serializeArray();
	$.post("ajax/cosm_search_feed.php", 
		postdata,
		function(data){$("#result").html(data);}// , "json" 
		);
});
$("#view_feed").click(function(){
	postdata = $(this).parent().serializeArray();
	$.post("ajax/cosm_view_feed.php",
		postdata,
		function(data){$("#result").html(data);}//, "json" 
		);
});
$("#view_db").click(function(){
	postdata = $(this).parent().serializeArray();
	$.post("ajax/get_from_db.php",
		postdata,
		function(data){$("#result").html(data);}//, "json" 
		);
});
</script>
<?php
require_once("footer.php");
?>