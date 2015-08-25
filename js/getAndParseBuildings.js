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
        hash = currentPrefix + buildingStr.substring(strIndex, strIndex + 3);
        typeCode = buildingStr[strIndex + 3];
        strIndex += 4;

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
                }).done(function(text) {

                    // FILL INFO BOX BASED ON BUILDING DATA (USE TEMPLATE FOR THIS)
                    loc = currentMarker.getPosition();
                    $('#modalText').html("Building with address: " + text 
                        + "<img src='https://maps.googleapis.com/maps/api/streetview?size=800x400&location=" 
                        + loc.lat() + "," + loc.lng() + "'/>");
                    });

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