<?php
	print "ciao";
	function drawGooglemaps($locations){
		
		$markers = array();
		foreach($locations as $location){
			$marker = explode(',',$location);
			$lat = $marker[0];
			$lng = $marker[1];
			$zoom = $marker[2];
			$titles = explode('|',$marker[3]);
			$title = $titles[0];
			$subtitle = $titles[1];
			$link = $marker[4];
			//$address = str_replace('|','<br/>',$marker[5]);
			$address = explode('|',$marker[5]);
			$street = $address[0];
			$location = $address[1];
			$area = $address[2];
			$zip = $address[3];
			$country = $address[4];
			$centerLat += $lat;
			$centerLng += $lng;
			$markers[] = array(
				'lat'=>$lat,
				'lng'=>$lng,
				'zoom'=>$zoom,
				'title'=>$title,
				'subtitle'=>$subtitle,
				'link'=>$link,
				'address'=>array(
					'street'=>$street,
					'location'=>$location,
					'area'=>$area,
					'zip'=>$zip,
					'country'=>$country
				)
			);
			$centerLat = $centerLat/count($markers);
			$centerLng = $centerLng/count($markers);
		}
		
		/*
		$xmlDoc = simplexml_load_file('map.xml');
		foreach($xmlDoc->children() as $marker){
			$lat = $marker->lat;
			$lng = $marker->lng;
			$title = $marker->title;
			$subtitle = $marker->subtitle;
			$link = $marker->link;	
			$address = $marker->address;
			$street = $address->street;
			$location = $address->location;
			$area = $address->area;
			$zip = $address->zip;
			$country = $address->country;
			//$address = $street.'<br/>'.$location.', '.$area.'<br/>'.$zip.' <strong>'.$country.'</strong><br/>';
			$markers[] = array(
				'lat'=>$lat,
				'lng'=>$lng,
				'zoom'=>$zoom,
				'title'=>$title,
				'subtitle'=>$subtitle,
				'link'=>$link,
				//'address'=>$address
				'address'=>array(
					'street'=>$street,
					'location'=>$location,
					'area'=>$area,
					'zip'=>$zip,
					'country'=>$country
				)
			);
		}
		*/
?>
		<br/>
		<div id="map" style="width: 640px; height: 380px"></div>
		<noscript><p><b>JavaScript must be enabled in order for you to use Google Maps.</b> However, it seems JavaScript is either disabled or not supported by your browser. 
		  To view Google Maps, enable JavaScript by changing your browser options, and then try again.</p>
		</noscript>
		<script type="text/javascript">
		//<![CDATA[

		if (GBrowserIsCompatible()) { 

			function createMarker(point,html) {
				
				// Create marker icon
				var basicIcon = new GIcon();
				basicIcon.image = "wp-content/themes/itgoesgreen/images/pointer.png";
				basicIcon.shadow = "wp-content/themes/itgoesgreen/images/pointer_shdw.png";
				//basicIcon.transparent = "wp-content/themes/itgoesgreen/images/pointer_trns.png";
				basicIcon.imageMap = [0,0, 28,0, 28,28, 10,28, 0,36];
				basicIcon.iconSize = new GSize(46,36);
				basicIcon.shadowSize = new GSize(46,36);
				basicIcon.iconAnchor = new GPoint(0,36);
				basicIcon.infoWindowAnchor = new GPoint(34,0);
				
				// Set up our GMarkerOptions object literal
				markerOptions = { icon:basicIcon };
				
				var marker = new GMarker(point,markerOptions);
				GEvent.addListener(marker, "click", function() {
					marker.openInfoWindowHtml(html);
				});
				return marker;
			}

			var map = new GMap2(document.getElementById("map"));
			map.setMapType(G_SATELLITE_MAP);
			map.addControl(new GLargeMapControl());
			map.addControl(new GMapTypeControl());
			map.setCenter(new GLatLng(<?php print $centerLat; ?>,<?php print $centerLng; ?>),<?php print $zoom; ?>);
			
			// Set up markers
			<?php
			
			foreach($markers as $marker){
				$infoString = '<p style="width:240px;height:120px;margin:0;padding:8px;text-align:left">';
				$infoString .= '<strong><span style="font-size:1.2em">'.$marker['title'].'</span>';
				$infoString .= '<br/><span style="font-size:1.1em">'.$marker['subtitle'].'</span></strong>';
				$infoString .= '<br/><a href="'.$marker['link'].'"/>'.$marker['link'].'</a>';
				$infoString .= '<br/><br/>'.$marker['address']['street'].'<br/>'.$marker['address']['location'];
				if($marker['address']['area']!=''){ $infoString .= ', '.$marker['address']['area']; }
				$infoString .= '<br/> '.$marker['address']['zip'].' <strong>'.$marker['address']['country'].'</strong><br/></p>';
			?> 
			var point = new GLatLng(<?php print $marker['lat']; ?>,<?php print $marker['lng']; ?>);
			var marker = createMarker(point,'<?php print $infoString; ?>');
			map.addOverlay(marker);
			<?php
				
			}
				
			?>
			
		}else{ alert("Sorry, the Google Maps API is not compatible with this browser"); }

		//]]>
		</script>
<?php

		/*
		
		$dom = new DOMDocument();
		$dom->preserveWhiteSpace = false;
		$dom->load('map.xml');
		$dom->formatOutput = true;
		$root = $dom->documentElement;
		$dom->appendChild($root);
		foreach($markers as $marker){
			//check if markers exists
			foreach(){
			
			}
			$m = $dom->createElement("marker");
			
				$lat = $dom->createElement("lat");
				$lat->appendChild($dom->createTextNode($marker['lat']));
				$m->appendChild($lat);
				
				$lng = $dom->createElement("lng");
				$lng->appendChild($dom->createTextNode($marker['lng']));
				$m->appendChild($lng);
			  
				$title = $dom->createElement("title");
				$title->appendChild($dom->createTextNode($marker['title']));
				$m->appendChild($title);
				
				$subtitle = $dom->createElement("subtitle");
				$subtitle->appendChild($dom->createTextNode($marker['subtitle']));
				$m->appendChild($subtitle);
				
				$link = $dom->createElement("link");
				$link->appendChild($dom->createTextNode($marker['link']));
				$m->appendChild($link);
				
				$address = $dom->createElement("address");
				
					$street = $dom->createElement("street");
					$street->appendChild($dom->createTextNode($marker['address']['street']));
					$address->appendChild($street);
					
					$location = $dom->createElement("location");
					$location->appendChild($dom->createTextNode($marker['address']['location']));
					$address->appendChild($location);
					
					$area = $dom->createElement("area");
					$area->appendChild($dom->createTextNode($marker['address']['area']));
					$address->appendChild($area);
					$country->appendChild($dom->createTextNode($marker['address']['country']));
					$address->appendChild($country);
				
				//$address->appendChild($dom->createTextNode($marker['address'] ));
				$m->appendChild($address);
			
			$root->appendChild($m);
		}
		
					
					$zip = $dom->createElement("zip");
					$zip->appendChild($dom->createTextNode($marker['address']['zip']));
					$address->appendChild($zip);
					
					$country = $dom->createElement("country");
		$file = fopen("map.xml","w");
		fwrite($file,$dom->saveXML());
		fclose($file);
		
		*/
		
	}
?>