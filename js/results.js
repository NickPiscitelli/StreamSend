$(function(){
	$('div.map').each(function(){
		var $map_canvas = $(this),
			lat, lng;

		// fetch lat/lng 
		try {
			lat = parseFloat($map_canvas.attr('data-lat'));
			lng = parseFloat($map_canvas.attr('data-lng'));
		} catch(ex) { lat = 0; lng = 0; }
		
		// initialize map/marker. save to map element
		var latlng = new google.maps.LatLng(lat, lng);
        $map_canvas[0].style.width = $map_canvas.width()+'px';
        $map_canvas.data('map',new google.maps.Map($map_canvas[0], {
          center: latlng,
          zoom: 14,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }));
        $map_canvas.data('marker',new google.maps.Marker({
		    position: latlng,
		    map: $map_canvas.data('map'),
		    title:"Location Marker"
		}));
	});
});