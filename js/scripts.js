(function init() {
  var dataKey = '1n-q5n4aaIn95SM0OGoZ6yDp0aSk4gfWeh0-yILHqAS8';
  var mapOptions = {
    center: {
      lat: 39.7392,
      lng: -104.9903
    },
    zoom: 11
  };

  var map = new google.maps.Map(document.getElementById('map'), mapOptions);
  function content(building) {
    {content: building.address1}
  };

  function addMarker(building_data) {
    var marker = new google.maps.Marker({
      map: map,
      position: new google.maps.LatLng(building_data.lat, building_data.lng),
    });
    console.log(building_data);
    var infowindow = new google.maps.InfoWindow({
      content: "<p>" + "<strong>Property Name: </strong>" + building_data.propertyname + "</p>" 
        + "<p>" + "<strong>Address: </strong>" + building_data.address  + "</p>"
        + "<p>" + "<strong>Energy Star Score: </strong>" + building_data.energyStarScore + "</p>"
        + "<p>" + "<strong>Energy Star Years: </strong>" + building_data.energyStarYears + "</p>"
        + "<p>" + "<strong>Energy Use Intensity (kbtu/sq ft): </strong>" + building_data.energyUseIntensity + "</p>"
        + "<p>" + "<strong>Property Type: </strong>" + building_data.propertyType + "</p>"
        + "<p>" + "<strong>Gross Square Footage: </strong>" + building_data.squareFootage + "</p>"
        + "<p>" + "<strong>Year Built: </strong>" + building_data.yearBuilt + "</p>"
        + "<p>" + "<strong>Building Website: </strong>" + building_data.website + "</p>"
        // + "<p>" + "<strong>Other Green Certifications / Programs: </strong>" + building_data. + "</p>"
        + "<p>" + "<strong>Top Energy Efficient Strategies: </strong>" + building_data.energyStrategies + "</p>"
    });

    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map, marker);
    });
  }

  

  function dataCallback(data, tabletop) {
    var benchmarked = data['Benchmarked Buildings'].elements;
    // var allBuildings = data['All Buildings over 10000 sq ft'].elements;

    benchmarked.forEach(function(building) {
      console.log(building);
      if (building.lat && building.lng) {
        addMarker(
          {
            lat: building.lat, 
            lng: building.lng, 
            address: building.address1,
            energyStarScore: building.energystarscore,
            energyStarYears: building['energystarcertification-yearscertified'],
            energyUseIntensity: building.weathernormalizedsiteeuikbtuft,
            propertyType: building['primarypropertytype-selfselected'],
            squareFootage: building.grosssquarefootage,
            yearBuilt: building.yearbuilt,
            website: building.buldingwebsite,
            // certifications: building.
            energyStrategies: building['whatarethetopthreeefficiencystrategiesyouhaveimplementedinyourbuildingifyourbuildinghasbeenwrittenupasacasestudypleaseincludethelinktoithereoremailittodenvercepdenvergov.org.']
          }
        );
      }
    });
  }

  Tabletop.init({
    key: dataKey,
    callback: dataCallback
  });
})();