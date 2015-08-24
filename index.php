<!DOCTYPE html>
<html>
  <head>
    <title>Building an Energy Efficient Denver</title>
    <style>
      #target {
        width: 345px;
      }
    </style>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }

		#pac-input {
		  background-color: #fff;
		  font-family: Roboto;
		  font-size: 15px;
		  font-weight: 300;
		  margin-left: 12px;
		  padding: 0 11px 0 13px;
		  text-overflow: ellipsis;
		  width: 300px;
		  margin-top: 10px;
		  border: 1px solid transparent;
		  border-radius: 2px 0 0 2px;
		  box-sizing: border-box;
		  -moz-box-sizing: border-box;
		  height: 32px;
		  outline: none;
		  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
		  font-family: Roboto;
		}
		
		#pac-input:focus {
		  border-color: #4d90fe;
		}
		
		#type-selector {
		  color: #fff;
		  background-color: #4d90fe;
		  padding: 5px 11px 0px 11px;
		}
		
		#type-selector label {
		  font-family: Roboto;
		  font-size: 13px;
		  font-weight: 300;
		}
		
		#legend {
	        font-family: Arial, sans-serif;
	        background: #fff;
	        padding: 10px;
	        margin: 10px;
	        border: 3px solid #000;
	      }
	      #legend h3 {
	        margin-top: 0;
	      }
	      #legend img {
	        vertical-align: middle;
	      }
    </style>
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
         <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--CLUSTER CODE <script type="text/javascript" src="js/markerclusterer.min.js"></script>-->
    <script type="text/javascript" src="js/geohash.js"></script>
  </head>
  <body>
  <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1596588600602607',
      xfbml      : true,
      version    : 'v2.4'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
  
  	<input id="pac-input" type="text" placeholder="Search Box" />
    <div id="map-canvas"></div>
    <div id="legend">
    </div>

      <script>

            function initMap() {
            	// Print a single string with the compressed series of points.  It is important that php tags line up with quotes.
            	var buildingStr = "<?php
      		include("utilities.php");
      		$result = $db_link->query("SELECT building_geohash, IFNULL(score_score, 0) AS score, building_gross_square_footage AS footage FROM buildings LEFT JOIN energy_star_score ON score_building_id=building_id ORDER BY building_geohash");
		
		$lastPrefix = '******';
		while ($row = mysqli_fetch_assoc($result)) {
			$hash = $row['building_geohash'];
			$score = $row['score'];
			$footage = $row['footage'];
			$typeCode = ($score > 0 ? 2 : 0) + ($footage >= 50000 ? 1 : 0); 
			
			$newPrefix = substr($hash, 0, 5);
			for ($i = 0; $i < 5; $i++) {
				if ($newPrefix[$i] != $lastPrefix[$i]) {
					break;
				}
			}
			$diffCount = 5 - $i;
			if ($diffCount > 0) {
				print '~'.$diffCount;
				print substr($newPrefix, 5 - $diffCount, $diffCount);
			}
			print substr($hash, 5, 3);
			print $typeCode;	
			
			$lastPrefix = $newPrefix;
		}
      	?>";
      	
                var mapOptions = {
                	zoom: 14,
                	center: new google.maps.LatLng(39.7384303,-104.9888331),
                    styles: [{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"poi.business", stylers: [ {visibility: "off" }]},
                    {"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}]
                };

                var mapElement = document.getElementById('map-canvas');

                var map = new google.maps.Map(mapElement, mapOptions);


		// SEARCH BOX CODE
                var input = document.getElementById('pac-input');
                var searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                // Bias the SearchBox results towards current map's viewport.
                map.addListener('bounds_changed', function() {
                  searchBox.setBounds(map.getBounds());
                });
		
		
		// LEGEND CODE
  		labels = new Array('Energy Star Buildings', 'Large buildings', 'Small Buildings');
  		icons = new Array('images/energy_star_logo_small.png', 'images/measle_blue.png', 'images/green_circle_icon_md_20px.png');
		 var legend = document.getElementById('legend');
		for (i = 0; i < labels.length; i++) {
		  var div = document.createElement('div');
		  div.innerHTML = '<img src="' + icons[i] + '"/> ' + labels[i];
		  legend.appendChild(div);
		}
		map.controls[google.maps.ControlPosition.TOP_RIGHT].push(legend);


                // PARSING CODE
                // CLUSTER CODE markers = new Array();      
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
		    
		    if(typeCode == 3 || typeCode == 2){
		      nextIcon = 'images/energy_star_logo_small.png';
		    } else if (typeCode == 1){
		      nextIcon = 'images/green_circle_icon_md_20px.png';
		    } else {
		      nextIcon = 'images/measle_blue.png';
		    }
		    coords = decodeGeoHash(hash);
		    
		    buildingMarker = new google.maps.Marker({
			    position: new google.maps.LatLng(coords.latitude[2], coords.longitude[2]),
			    map: map,
			    icon: nextIcon
			}); 
			// CLUSTER CODE markers.push(buildingMarker);
		    (function(a) {
		    buildingMarker.addListener('click', function() {
                  	map.setZoom(17);
                  	map.panTo(this.getPosition());
                  	$('#popupModal').openModal({opacity: 0});
                  	$.ajax({
			  url: "details.php",
			  method: "GET",
			  data: { id: a }
			}).done(function(text) {
			  $('#modalText').text("Building with address: " + text);
			});
               	    });
               	    }(hash));
		}
		//CLUSTER CODE var markerCluster = new MarkerClusterer(map, markers);

                searchBox.addListener('places_changed', function() {
                    var places = searchBox.getPlaces();

                    if (places.length == 0) {
                      return;
                    }

                    // For each place, get the icon, name and location.
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function(place) {
                      if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                      } else {
                        bounds.extend(place.geometry.location);
                      }
                    });
                    
			address = places[0].formatted_address;
			var infoWindow = new google.maps.InfoWindow({
   			 content: address
			});
			var marker = new google.maps.Marker({
				position: places[0].geometry.location,
			    map: map,
			    infoWindow: infoWindow
			});
			infoWindow.open(map, marker);
                    if (bounds.getNorthEast().equals(bounds.getSouthWest())) {
                        var extendPoint1 = new google.maps.LatLng(bounds.getNorthEast().lat() + 0.001, bounds.getNorthEast().lng() + 0.001);
                        var extendPoint2 = new google.maps.LatLng(bounds.getNorthEast().lat() - 0.001, bounds.getNorthEast().lng() - 0.001);
                        bounds.extend(extendPoint1);
                        bounds.extend(extendPoint2);
                    }
                    map.fitBounds(bounds);
                  });
            }
            
            $(document).ready(function(){
            	 setTimeout(function() { $('#popupModal').openModal({opacity: 0}); }, 500);
            });
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap"
         async defer></script>
  
  <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large brown modal-trigger" href="#loginModal">
      <i class="large material-icons">vpn_key</i>
    </a>
    <ul>
      <li><a class="btn-floating red modal-trigger"><i class="material-icons">vpn_key</i></a></li>
      <li><a class="btn-floating yellow darken-1"><i class="material-icons">add</i></a></li>
    </ul>
  </div>
  
  <div id="loginModal" class="modal">
    <div class="modal-content">
      <h4>Login/Register</h4>
      <p>You don't need an account to find farmstands, but creating one will allow you to publish or contact farmstands and leave comments/reviews. 
   <form class="col s12">
      <div class="row" style="padding-top:0px;margin-top:0px;">
        <div class="input-field col s12" style="padding-top:0px;margin-top:0px;">
          <input id="loginEmail" type="email" class="validate" style="padding-bottom:0px;margin-bottom:0px;">
          <label for="email">Email</label>
        </div>
      </div>
      <div class="row" style="padding-top:0px;margin-top:0px;">
        <div class="input-field col s12" style="padding-top:0px;margin-top:0px;">
          <input id="loginPassword" type="password" class="validate" style="padding-bottom:0px;margin-bottom:0px;">
          <label for="password">Password</label>
        </div>
      </div>
      <div id='registerDiv' style='display:none;'>
	      <div class="row">
	        <div class="input-field col s12" style='margin-top:0px;'>
	          <input id="loginConfirmPassword" type="password" class="validate" style="padding-bottom:0px;margin-bottom:0px;">
	          <label for="loginConfirmPassword">Confirm Password</label>
	        </div>
	      </div>   
	      <TABLE style="padding:0px;margin:0px;"><TR><TD style="padding:0px;margin:0px;">
	      <div class="row">
	        <div class="input-field col s12" style='margin-top:0px;padding-top:0px;'>
	          <input id="loginFirstName" type="text" class="validate">
	          <label for="loginFirstName">First Name</label>
	        </div>
	      </div>
	      </TD><TD>
	      <div class="row">
	        <div class="input-field col s12" style='margin-top:0px;padding-top:0px;'>
	          <input id="loginLastName" type="text" class="validate">
	          <label for="loginLastName">Last Name</label>
	        </div>
	      </div>
	      </TD></TR></TABLE>
      </div>
      <button class="btn waves-effect waves-light" type="submit" name="action" id='loginButton'>
    		Login <i class="material-icons">vpn_key</i>
  	  </button>
    </form>
      <p id='registerLink'>Don't have an account?  <a href="" onclick="document.getElementById('registerDiv').style.display='inline'; document.getElementById('loginButton').innerHTML='Create Account <i class=\'material-icons\'>perm_identity</i>';document.getElementById('registerLink').style.display='none';return false;">Register now</a></p>
    </div>
  </div>
  
  <!-- Modal Structure -->
  <div id="popupModal" class="modal bottom-sheet" style="">
    <div class="modal-content" style="max-width:600px;align:center;">
      <H4 style="font-size:18px;font-style:bold;">Building an Energy Efficient Denver</H4>
      <p style="font-size:14px;" id='modalText'>The energy used in commercial buildings, apartments and condos is responsible for 57% of the greenhouse gas emissions in Denver. Together we can cut that by 20% for $1.3 billion in energy savings. The first step in improving energy efficiency is to measure it. You know the miles per gallon of your car, but do you know the 1-100 ENERGY STAR score of the buildings where you live and work? Click on the markers above to find out!</p>
    </div>
  </div>
          
  </body>
</html>