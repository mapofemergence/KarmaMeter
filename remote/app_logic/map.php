<html>
<head></head>
<body onload="load()">
    <div id="map" style="width: 100%; height: 600px"></div>
  </body>
<div >
</div>
<!--script part-->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
var customIcons = {
      cre_1: {
        icon: 'whale_button.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      cre_2: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      }
    };

function downloadUrl(url,callback) {
	 var request = window.ActiveXObject ?
		 new ActiveXObject('Microsoft.XMLHTTP') :
		 new XMLHttpRequest;

	 request.onreadystatechange = function() {
	   if (request.readyState == 4) {
		 request.onreadystatechange = doNothing;
		 callback(request, request.status);
	   }
	 };

	 request.open('GET', url, true);
	 request.send(null);
}
function load(){
	var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(41.88357, 12.47445),
        zoom: 13,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;
	downloadUrl("api/db_to_map.php", function(data) {
	  var xml = data.responseXML;
	  var markers = xml.documentElement.getElementsByTagName("marker");
	  for (var i = 0; i < markers.length; i++) {
		var name = markers[i].getAttribute("id_user");
		var creature = markers[i].getAttribute("creature");
		var time = markers[i].getAttribute("time");
		var point = new google.maps.LatLng(
			parseFloat(markers[i].getAttribute("lat")),
			parseFloat(markers[i].getAttribute("lng")));
		var html = "user id: <b>" + name + "</b> <br/>creature: " + creature + "<br/> tagget at "+ time;
		var icon = customIcons["cre_" + creature] || {};
		var marker = new google.maps.Marker({
		  map: map,
		  position: point,
		  icon: icon.icon,
		  shadow: icon.shadow
		});
		bindInfoWindow(marker, map, infoWindow, html);
	  }
	})
};
function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }
function downloadUrl(url, callback) {
	var request = window.ActiveXObject ?
	  new ActiveXObject('Microsoft.XMLHTTP') :
	  new XMLHttpRequest;

	request.onreadystatechange = function() {
		if (request.readyState == 4) {
		  request.onreadystatechange = doNothing;
		  callback(request, request.status);
		}
	};

	request.open('GET', url, true);
	request.send(null);
}

function doNothing() {}


</script>
<?php
require_once("footer.php");
?>