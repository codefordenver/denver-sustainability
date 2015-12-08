function initLegend(map) {
    // List of legend labels.
    var labels = new Array(
      {title: 'ENERGY STAR', subtitle: 'certified 2014'},
      {title: 'Benchmarked', subtitle: 'score measured'},
      {title: 'Unbenchmarked', subtitle: 'score unknown'},
      {title: 'Reset visible', subtitle: 'show all buildings'}
    );
    // List of legend icons
    var icons = new Array('images/energy_star_logo_small.png', 'images/icon-circle-greenx20.png', 
      'images/icon-circle-grayx20.png', 'images/small-check.png');
    // List of filter operators
    var filters = new Array('blue', 'green', 'gray', '');
    var legend = document.getElementById('legend');
    for (i = 0; i < labels.length; i++) {
      var div = document.createElement('div');
      div.id = "legendItem" + i;
      legend.appendChild(div);
      var template = $('#legend_item').html();
      Mustache.parse(template);   // optional, speeds up future uses
      var rendered = Mustache.render(template, {icon: icons[i], title: labels[i].title, 
        subtitle: labels[i].subtitle, onclick: "filterMarkers('"+filters[i]+"');"
      });  
      $("#legendItem" + i).html(rendered);
    }
    //control position
    map.controls[google.maps.ControlPosition.LEFT_TOP].push(legend);
}


function filterMarkers(buildingColor){
  // set buildingColor to '' to restore all markers
  var visibility = false;
  var markersArray = [greenBuildings, grayBuildings, energyStarBuildings];

  function setVisibile(markerArray, visibile){
    if (visibile) {
      var state = map;
      // if we're setting something visible that is already visible, skip it
      if (markerArray[0].getMap() !== null){
        return;
      }
    } else {
      var state = null;
    }

    markerArray.forEach(function(point){
      point.setMap(state);
    });
  }

  if (buildingColor=='green') {
    // remove green marker array and set it visible, remaining arrays are set not visible
    setVisibile(markersArray.splice(0,1)[0], true);
  } else if (buildingColor=='gray'){
    setVisibile(markersArray.splice(1,1)[0], true);
  } else if (buildingColor=='blue'){
    setVisibile(markersArray.splice(2,1)[0], true);
  } else {
    markersArray.forEach(function(array, index){
      if (array[0].getMap() !== null){
        markersArray.splice(index,1)[0];
      }
    });
    visibility = true;
  }
  for (var i = 0; i < markersArray.length; i++) {
    setVisibile(markersArray[i], visibility);
  }
}
