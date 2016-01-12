function initMap() {      	
    // INIT BASIC MAP
    var mapOptions = {
        zoom: 14,
        center: new google.maps.LatLng(39.7384303,-104.9888331), 
        
        //streetview position
        scaleControl: true,
        streetViewControl: true,
        streetViewControlOptions: {
        position: google.maps.ControlPosition.RIGHT_TOP
    
    },
        //zooming position
        zoomControl: true,
        zoomControlOptions: {
        position: google.maps.ControlPosition.RIGHT_TOP   
    },
        
        
    };

    var mapElement = document.getElementById('map-canvas');
    map = new google.maps.Map(mapElement, mapOptions);
    google.maps.event.addListener(map, 'click', function() { $("#popupModal").closeModal(c); });
    
    initSearchBox(map);
    initLegend(map);
    plotBuildings(map);
} // END MAP INITIALIZATION
		
