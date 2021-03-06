energyStarBuildings = [];
grayBuildings = [];
greenBuildings = [];
function parseBuildings(buildingStr, map) {    
    /** CLUSTER CODE **/ // markers = new Array();     
    var e = 0; 
    var gr = 0;
    var grey = 0;
    // PARSING CODE
    currentPrefix = '*****';
    strIndex = 0;
    var tempList = [];
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
        if(typeCode == 0){
          continue;  // we don't need to show buildings of this type anymore
        } else if (typeCode == 1){
          nextIcon = 'images/icon-circle-greenx7.png';
          gr = gr + 1;
          tempList = greenBuildings;
        } else if (typeCode == 2){
          nextIcon = 'images/icon-small-blue-square7x7.png';
          tempList = energyStarBuildings;
          e = e + 1;  
        } else if (typeCode == 4){
          nextIcon = 'images/icon-circle-grayx20.png';
          tempList = grayBuildings;
          grey = grey + 1;
        } else if (typeCode == 5){
          nextIcon = 'images/icon-circle-greenx20.png';
          tempList = greenBuildings;
          gr = gr + 1;
        } else {
          nextIcon = 'images/energy_star_logo_small.png';
          tempList = energyStarBuildings;
          e = e + 1;
        }
        // END ICON RULES

        coords = decodeGeoHash(hash);

        buildingMarker = new google.maps.Marker({
            position: new google.maps.LatLng(coords.latitude[2], coords.longitude[2]),
            map: map,
            icon: nextIcon
        });

        tempList.push(buildingMarker);

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
    var x = (((e + gr) / (e + grey + gr))*100);
    var y = document.getElementById("progressBarValue");
    var p = document.getElementById("percentOfBuilding");
    p.innerHTML = x.toFixed(1);
    y.style.width = x + "%";
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