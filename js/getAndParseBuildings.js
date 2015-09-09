function parseBuildings(buildingStr, map) {    
    /** CLUSTER CODE **/ // markers = new Array();     
                
    // PARSING CODE
    currentPrefix = '*****';
    strIndex = 0;
    while (strIndex < buildingStr.length) {
        if (buildingStr[strIndex] == '~') {
            numDiff = parseInt(buildingStr[strIndex + 1]);
            currentPrefix = currentPrefix.substring(0, 5 - numDiff) + buildingStr.substring(strIndex + 2, strIndex + 2 + numDiff);
            strIndex += 2 + numDiff;
        }
        hash = currentPrefix + buildingStr.substring(strIndex, strIndex + 4);
        typeCode = buildingStr[strIndex + 4];
        strIndex += 5;

        // ICON RULES
        if(typeCode == 3 || typeCode == 2){
          nextIcon = 'images/energy_star_logo_small.png';
        } else if (typeCode == 1){
          nextIcon = 'images/green_circle_icon_md_20px.png';
        } else {
          nextIcon = 'images/measle_blue.png';
        }
        // END ICON RULES

        coords = decodeGeoHash(hash);

        buildingMarker = new google.maps.Marker({
            position: new google.maps.LatLng(coords.latitude[2], coords.longitude[2]),
            map: map,
            icon: nextIcon
        });

        /** CLUSTER CODE **/ //markers.push(buildingMarker);

        // APPLY TO EACH HASH
        (function(a) {
            // RESPOND TO MARKER CLICKS
            buildingMarker.addListener('click', function() {
                map.setZoom(17);
                map.panTo(this.getPosition());
                $('#popupModal').openModal({opacity: 0});
                (function(currentMarker) {
                    // RETRIEVE DATA FROM SERVER.  
                    $.ajax({
                        url: BASE_URL + "details.php",
                        method: "GET",
                        data: { id: a }
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
                    }); // END TEMPLATE FILL
                }(this));
            }); // END RESPOND TO MARKER CLICK
        }(hash));
        // END APPLY TO EACH HASH	
    }
    // END PARSING CODE
}
    
function plotBuildings(map) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", BASE_URL + "getGeohashedBuildings.php", true);
  xhr.onreadystatechange = function() {
    var responseText = xhr.responseText; 
    parseBuildings(responseText, map);  
  };
  xhr.send();
}