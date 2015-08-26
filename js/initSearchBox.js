function initSearchBox(map) {
    var input = document.getElementById('search-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    // RESPOND TO SEARCH RESULT CLICK
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        map.setZoom(17);
        map.panTo(places[0].geometry.location);
        $('#popupModal').openModal({opacity: 0});
        $.ajax({
            url: BASE_URL + "place_id_details.php",
            method: "GET",
            data: { id: places[0].id}
        }).done(function(text) {
            loc = places[0].geometry.location;
            $('#modalText').html("Building with address: " + text 
                    + "<img src='https://maps.googleapis.com/maps/api/streetview?size=800x400&location=" 
                    + loc.lat() + "," + loc.lng() + "'/>"
            );
        });
    }); // END RESPOND TO SEARCH RESULT CLICK
}