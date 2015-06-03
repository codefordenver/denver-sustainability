(function init() {
  var dataKey = '1n-q5n4aaIn95SM0OGoZ6yDp0aSk4gfWeh0-yILHqAS8';
  var mapOptions = {
    center: {
      lat: 39.7392,
      lng: -104.9903
    },
    zoom: 10
  };

  var map = new google.maps.Map(document.getElementById('map'), mapOptions);

  var geocoder = new google.maps.Geocoder();

  function addMarker(loc) {
    var marker = new google.maps.Marker({
      map: map,
      position: loc.geometry.location
    });
  }

  function dataCallback(data, tabletop) {
    console.log(data);

    data.forEach(function(building) {
      geocoder.geocode({
        address: building.address1 + ' Denver'
      }, function(locs) {
        addMarker(locs[0]);
      })
    })
  }

  Tabletop.init({
    key: dataKey,
    callback: dataCallback,
    simpleSheet: true
  });
})();