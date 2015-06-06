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

  function addMarker(loc) {
    var marker = new google.maps.Marker({
      map: map,
      position: new google.maps.LatLng(loc.lat, loc.lng)
    });
  }

  function dataCallback(data, tabletop) {
    console.log(data);

    var benchmarked = data['Benchmarked Buildings'].elements;
    var allBuildings = data['All Buildings over 10000 sq ft'].elements;

    benchmarked.forEach(function(building) {
      if (building.lat && building.lng) {
        addMarker({lat: building.lat, lng: building.lng});
      }
    });
  }

  Tabletop.init({
    key: dataKey,
    callback: dataCallback
  });
})();