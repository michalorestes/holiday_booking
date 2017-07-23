//Adapted from 
//https://developers.google.com/maps/documentation/javascript/examples/geocoding-region-es

function initMap() {
	var postCode = document.getElementById('postCode').innerHTML;
		
    var map = new google.maps.Map(document.getElementById('map'), {zoom: 15});
    var geocoder = new google.maps.Geocoder;
	var place = {'address': postCode};
    geocoder.geocode(place, function(results, status) {
    	if (status === 'OK') {
			map.setCenter(results[0].geometry.location);
			new google.maps.Marker({
				map: map,
				position: results[0].geometry.location
				});
        } else {
            window.alert('Geocode was not successful for the following reason: ' +
                status);
        }
    });
}