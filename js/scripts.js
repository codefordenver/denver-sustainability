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

    var workingData = data['All Buildings over 10000 sq ft'].elements;
    var addressHeader = 'physicaladdress';

    var i = 0,
        offset = 0,
        locations = [],
        subsetSize = 1,
        delay = 1000,
        failed = 0;

    var addressList = [];
    var latList = [];
    var lngList = [];

    // Work with Google's 5 requests per second rate limit
    function geoCodeUnknown(i) {
      if (i >= workingData.length) {
        return done();
      }

      var building = workingData[i];
      if (building.googleaddress && building.lat && building.lng) {
        addressList.push(building.googleaddress);
        latList.push(building.lat);
        lngList.push(building.lng);

        console.log(i);
        i++;
        return geoCodeUnknown(i);
      }

      geocoder.geocode({
        address: building[addressHeader] + ' Denver'
      }, function(locs) {
        locs && locs[0] && addMarker(locs[0]);

        if (!locs) console.log('failed', ++failed)

        locations.push(locs ? locs[0] : null); // take first guess

        addressList.push(locs ? locs[0].formatted_address : null);
        latList.push(locs ? locs[0].geometry.location.lat() : null);
        lngList.push(locs ? locs[0].geometry.location.lng() : null);

        console.log(i);
        i++;
        setTimeout(geoCodeUnknown.bind(this, i), delay);
      }.bind(this));
    }

    geoCodeUnknown(0);

    function done() {
      // In chome dev tools use copy(addressList.join('\n'))
      // to get a list of address in format to paste in spreadsheet
      window.addressList = addressList;
      window.latList = latList;
      window.lngList = lngList;
      debugger;
    }
  }

  Tabletop.init({
    key: dataKey,
    callback: dataCallback,
    // simpleSheet: true
  });
})();