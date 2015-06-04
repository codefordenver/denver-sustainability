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

    var i = 0,
        locations = [],
        subsetSize = 1,
        delay = 1000,
        failed = 0;

    // Work with Google's 10 requests per second rate limit
    var interval = setInterval(function(){
      var subset = data.slice(i*subsetSize, (i+1)*subsetSize);

      console.log('i', i)
      i++;

      subset.forEach(function(building) {
        geocoder.geocode({
          address: building.address1 + ' Denver'
        }, function(locs) {
          locs && locs[0] && addMarker(locs[0]);

          if (!locs) console.log('failed', failed++)

          Array.prototype.push.apply(locations, locs);
        });
      });

      if (i*subsetSize > data.length) {
        clearInterval(interval);
        console.log(locations)
      }
    }, delay);

    // data.forEach(function(building) {
    //   geocoder.geocode({
    //     address: building.address1 + ' Denver'
    //   }, function(locs) {
    //     locs && locs[0] && addMarker(locs[0]);
    //   });
    // })
  }

  Tabletop.init({
    key: dataKey,
    callback: dataCallback,
    simpleSheet: true
  });
})();