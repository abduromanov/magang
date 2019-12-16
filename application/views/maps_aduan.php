<div id="googleMap"	></div>

<script type="text/javascript">
	var karanganyar = {lat: -7.6164401, lng: 110.9894384};
	var map;
	var poly;
	function create_map(){
		var mapCenter = {
			center:new google.maps.LatLng(karanganyar),
			zoom:11,
			// gestureHandling: 'none',
			disableDefaultUI: true
		};
		map = new google.maps.Map(document.getElementById("googleMap"), mapCenter);
		var jalan = '<?php echo base_url()?>data/jalan2.geojson';

		var jalanLayer = new google.maps.Data({map: map});
		var idDb = <?php echo $this->uri->segment(3); ?>;

		var firstPoint;
		var paths = [];
		jalanLayer.loadGeoJson(jalan,{},function(features){
			jalanLayer.forEach(function(feature){
				if (feature.getProperty('id_jalan') == idDb) {
			        feature.getGeometry().forEachLatLng(function(path) {
			        	paths.push(path);
			        });
			        firstPoint = paths[0];

			        poly = new google.maps.Polyline({
						path: paths,
				        strokeColor: 'red',
				        strokeOpacity: 2.0,
				        strokeWeight: 3
			        });
			        poly.setMap(map);
			        zoomToObject(poly);
			    }
			});
			var marker = new google.maps.Marker({
		        position: firstPoint,
		        map: map,
		        draggable: true
		    });

		    marker.addListener('dragend', function(e){
		    	marker.setPosition(find_closest_point_on_path(e.latLng,paths));
		    	var a = marker.getPosition();
		    	document.getElementById('titik').value = a;
		    });

		    marker.addListener('drag', function(e){
		    	marker.setPosition(find_closest_point_on_path(e.latLng,paths));
		    });
		    
		});

		jalanLayer.setMap(null);
	}

	function zoomToObject(obj){
	    var bounds = new google.maps.LatLngBounds();
	    var points = obj.getPath().getArray();
	    for (var i = 0; i < points.length ; i++){
	        bounds.extend(points[i]);
	    }
	    map.fitBounds(bounds);
	}

	function find_closest_point_on_path(drop_pt,path_pts){
        distances = []//new Array();//Stores the distances of each pt on the path from the marker point 
        distance_keys = []//new Array();//Stores the key of point on the path that corresponds to a distance
        
        //For each point on the path
        $.each(path_pts,function(key, path_pt){
            //Find the distance in a linear crows-flight line between the marker point and the current path point
            var R = 12742; // km
            var dLat = (path_pt.lat()-drop_pt.lat()).toRad();
            var dLon = (path_pt.lng()-drop_pt.lng()).toRad();
            var lat1 = drop_pt.lat().toRad();
            var lat2 = path_pt.lat().toRad();

            var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
            var d = R * c;
            //Store the distances and the key of the pt that matches that distance
            distances[key] = d;
            distance_keys[d] = key; 
            
        });
        //Return the latLng obj of the second closest point to the markers drag origin. If this point doesn't exist snap it to the actual closest point as this should always exist
        return (typeof path_pts[distance_keys[Math.min(...distances)]+1] === 'undefined')?path_pts[distance_keys[Math.min(...distances)]]:path_pts[distance_keys[Math.min(...distances)]+1];
    }

    /** Converts numeric degrees to radians */
    if (typeof(Number.prototype.toRad) === "undefined") {
    	Number.prototype.toRad = function() {
    		return this * Math.PI / 180;
    	}
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEIAOa6sUw5v4RyfchsJK2IXcJ1mwUcEs&callback=create_map"></script>