function initMap() {      	
    // INIT BASIC MAP
    var mapOptions = {
        zoom: 14,
        center: new google.maps.LatLng(39.7384303,-104.9888331)
    };

    var mapElement = document.getElementById('map-canvas');
    map = new google.maps.Map(mapElement, mapOptions);
    google.maps.event.addListener(map, 'click', function() { $("#popupModal").closeModal(c); });
    
    initSearchBox(map);
    initLegend(map);
    plotBuildings(map);
} // END MAP INITIALIZATION
		