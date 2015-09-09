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
            url: BASE_URL + "details.php",
            method: "GET",
            data: { place_id: places[0].place_id}
        }).done(function(json) {
            // FILL TEMPLATE FOR CLICKED BUILDING
                        var obj = jQuery.parseJSON(json);
                        var template = $('#building_info').html();
                        Mustache.parse(template);
                        var rendered = Mustache.render(template, 
                            {
                                name: obj.building_name,
                                address: obj.building_address,
                                lat: obj.building_lat,
                                lng: obj.building_lng,
                                geocodedAddress: obj.building_geocoded_address,
                                squareFootage: obj.building_gross_square_footage,
                                yearBuilt: obj.building_year_built,
                                website: obj.building_website,
                                updated: obj.building_updated,
                                propertyType: obj.building_sector,
                                sourcePrim: obj.building_source_prim,
                                numUnits: obj.building_number_units,
                                geocodedLat: obj.building_geocoded_lat,
                                geocodedLng: obj.building_geocoded_lng,
                                building_geohash: obj.building_geohash,
                                viewCount: obj.building_view_count,
                                energyStarScore: obj.score_score,
                                certifications: obj.certifications,
                                strategies: obj.strategies,
                                energyUseIntensity: obj.score_wns_eui
                            });  
                        $("#popupModalContent").html(rendered);
        });
    }); // END RESPOND TO SEARCH RESULT CLICK
}