<div id="googleMap"	></div>

<script type="text/javascript">
	var karanganyar = {lat: -7.6164401, lng: 110.9894384};
	var map;
	function create_map(){
		var mapCenter = {
			center:new google.maps.LatLng(karanganyar),
			zoom:11,
			streetViewControl:false
		};
		map = new google.maps.Map(document.getElementById("googleMap"), mapCenter);
		var jalan = 'data/jalan2.geojson';
		var kec = 'data/kecamatan.geojson';

		var jalanLayer = new google.maps.Data({map: map});
		var kecLayer = new google.maps.Data({map: map});

		jalanLayer.loadGeoJson(jalan);

		jalanLayer.setStyle(function(feature){
			var colorLine = '#ff8300'; 
			if (feature.getProperty('isColorful')) {
				colorLine = '#ffff00';
			}
			var lineWidth = '2';
			var opacity = '2';

			return{
				strokeColor: colorLine,
				strokeWeight: lineWidth,
				strokeOpacity: opacity
			};
		});

		kecLayer.setStyle(function(feature){
			var fillColor = feature.getProperty('fill');
			var fillOpacity = feature.getProperty('fill-opacity')
			var colorLine = feature.getProperty('stroke');
			var lineWidth = '0.5';
			var opacity = feature.getProperty('stroke-opacity');

			return{
				fillColor: fillColor,
				strokeColor: colorLine,
				strokeWeight: lineWidth,
				strokeOpacity: opacity
			};
		});

		var infoJalan = new google.maps.InfoWindow();

		jalanLayer.addListener('click', function(event){
			var bounds = new google.maps.LatLngBounds();
		    processPoints(event.feature.getGeometry(), bounds.extend, bounds);
		    map.fitBounds(bounds);
			event.feature.setProperty('isColorful', false);
			$.ajax({
				url: '<?php echo site_url('c_user/info_jalan/') ?>/'+event.feature.getProperty('id_jalan'),
				success: function(data){
					event.feature.setProperty('isColorful', true);
					infoJalan.setContent(data);
					infoJalan.setPosition(event.latLng);
					infoJalan.open(map);
				}
			});
		});

		jalanLayer.addListener('mouseover', function(event){
			event.feature.setProperty('isColorful', true);
		});

		jalanLayer.addListener('mouseout', function(event){
			event.feature.setProperty('isColorful', false);
		});
	}

	function processPoints(geometry, callback, thisArg) {
		if (geometry instanceof google.maps.LatLng) {
	    	callback.call(thisArg, geometry);
		} else if (geometry instanceof google.maps.Data.Point) {
		    callback.call(thisArg, geometry.get());
		} else {
		    geometry.getArray().forEach(function(g) {
		    	processPoints(g, callback, thisArg);
		    });
		}
	}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEIAOa6sUw5v4RyfchsJK2IXcJ1mwUcEs&callback=create_map"></script>