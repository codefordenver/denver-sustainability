function initMap() {      	
    // INIT BASIC MAP
    var mapOptions = {
        zoom: 14,
        center: new google.maps.LatLng(39.7384303,-104.9888331),
        // styles: [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"poi.business", stylers: [ {visibility: "off" }]},
        // {"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}]
    }; <!-- TO CHANGE STYLE, USE SNAZZY MAPS AND COPY+PASTE ABOVE -->

    var mapElement = document.getElementById('map-canvas');
    map = new google.maps.Map(mapElement, mapOptions);
    google.maps.event.addListener(map, 'click', function() { $("#popupModal").closeModal(c); });
    
    initSearchBox(map);
    initLegend(map);
    plotBuildings(map);
} // END MAP INITIALIZATION
		