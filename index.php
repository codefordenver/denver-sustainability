<!DOCTYPE html>
<html>
  <head>
    <title>Building an Energy Efficient Denver</title>
    
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	
	<link type="text/css" rel="stylesheet" href="styles/main.css" />
    <link type="text/css" rel="stylesheet" href="styles/lib/materialize.min.css"  media="screen,projection"/>
 
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
         
	<script type="text/javascript" src="js/lib/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/lib/materialize.min.js"></script>
    <!--CLUSTER CODE <script type="text/javascript" src="js/markerclusterer.min.js"></script>-->
    <script type="text/javascript" src="js/lib/geohash.js"></script>
  
  </head>
  
  <body>
	<script type="text/javascript" src="js/facebookInit.js"></script>
  
  	<input id="search-input" type="text" placeholder="Search Box" />
    
	<div id="map-canvas"></div>
    
	<div id="legend"></div>

      <script>
			var BASE_URL = "http://foodnextdoor.org/denverenergystars/php/";
	  
            function initMap() {
            	// Print a single string with the compressed series of points.  It is important that php tags line up with quotes.
            	var buildingStr = "<?php include("php/getGeohashedBuildings.php"); ?>";
      	
		
		
				// INIT BASIC MAP
                var mapOptions = {
                	zoom: 14,
                	center: new google.maps.LatLng(39.7384303,-104.9888331),
                    styles: [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"poi.business", stylers: [ {visibility: "off" }]},
                    {"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}]
                }; <!-- TO CHANGE STYLE, USE SNAZZY MAPS AND COPY+PASTE ABOVE -->

                var mapElement = document.getElementById('map-canvas');
                var map = new google.maps.Map(mapElement, mapOptions);

				// BEGIN SEARCH BOX CODE
                var input = document.getElementById('search-input');
                var searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                // Bias the SearchBox results towards current map's viewport.
                map.addListener('bounds_changed', function() {
                  searchBox.setBounds(map.getBounds());
                });
				// END SEARCH BOX CODE
		
				// LEGEND CODE
				
				// List of legend labels.
				labels = new Array('Energy Star Buildings', 'Large buildings', 'Small Buildings');
				// List of legend icons
				icons = new Array('images/energy_star_logo_small.png', 'images/measle_blue.png', 'images/green_circle_icon_md_20px.png');
				var legend = document.getElementById('legend');
				for (i = 0; i < labels.length; i++) {
				  var div = document.createElement('div');
				  
				  // HTML FOR SINGLE LEGEND ELEMENT
				  div.innerHTML = "<TABLE style='height:15px;'>" 
								+   "<TR>"
								+			"<TD style='text-align:center;width:45px;'>"
								+			"<img src='" 
								+ 				icons[i] 
								+ 				"'/>"
								+			"</TD>"
								+			"<TD>"
								+ 				labels[i]
								+			"</TD>"
								+		"</TR>" 
								+	"</TABLE>"
									
				  // END LEGEND ELEMENT HTML.
				  
				  legend.appendChild(div);
				}
				
				map.controls[google.maps.ControlPosition.TOP_RIGHT].push(legend);
				// END LEGEND CODE
                
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
				
				// END PARSING CODE
				
			} // END MAP INITIALIZATION
		
			/**CLUSTER CODE**/ //var markerCluster = new MarkerClusterer(map, markers);

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
								+ loc.lat() + "," + loc.lng() + "'/>");
					});

                });
            } // END RESPOND TO SEARCH RESULT CLICK
            
			// POP UP BOTTOM DRAWER HALF A SECOND AFTER PAGE LOADS.
            $(document).ready(function(){
            	 setTimeout(function() { $('#popupModal').openModal({opacity: 0}); }, 500);
            });
        </script>
		
		<!-- When page ready, load map -->
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap"
				async defer></script>
  
  <!-- BUBBLE UP BUTTONS IN BOTTOM-RIGHT -->
  <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large brown modal-trigger" href="#loginModal">
      <i class="large material-icons">vpn_key</i>
    </a>
    <ul>
      <li><a class="btn-floating red modal-trigger"><i class="material-icons">vpn_key</i></a></li>
      <li><a class="btn-floating yellow darken-1"><i class="material-icons">add</i></a></li>
    </ul>
  </div>
  <!-- END BUBBLE UP MENU -->
  
  <!-- LOGIN MODAL: NOT CURRENTLY IMPLEMENTED -->
  <div id="loginModal" class="modal">
    <div class="modal-content">
		<?php include("html/login.html"); ?>
	</div>
  </div>
  <!-- END LOGIN MODAL -->
  
  <!-- BOTTOM DRAWER -->
  <div id="popupModal" class="modal bottom-sheet" style="border-radius:15px;">
    <div class="modal-content" style="max-width:600px;align:center;">
      <?php include("html/bottom_drawer_splash.html"); ?>
    </div>
  </div>
  <!-- END BOTTOM DRAWER -->
          
  </body>
</html>