function initLegend(map) {
    // List of legend labels.
    var labels = new Array(
      {title: 'ENERGY STAR', subtitle: 'certified 2014'},
      {title: 'Benchmarked', subtitle: 'score measured'},
      {title: 'Unbenchmarked', subtitle: 'score unknown'}
     );
    // List of legend icons
    var icons = new Array('images/energy_star_logo_small.png', 'images/icon-circle-greenx20.png', 'images/icon-circle-grayx20.png');
    // List of filter operators
    var filters = new Array();
    var legend = document.getElementById('legend');
    for (i = 0; i < labels.length; i++) {
      var div = document.createElement('div');
      div.id = "legendItem" + i;
      legend.appendChild(div);
      var template = $('#legend_item').html();
      Mustache.parse(template);   // optional, speeds up future uses
      var rendered = Mustache.render(template, {icon: icons[i], title: labels[i].title, subtitle: labels[i].subtitle});  
      $("#legendItem" + i).html(rendered);
    }

    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(legend);
}

function filterLegend(buildingColor, map){
  // set buildingColor to '' to restore all markers
  var state = null;
  var markersArray = [];
  if (buildingColor=='green') {
    markersArray = grayBuildings.concat(energyStarBuildings);
  } else if (buildingColor=='gray'){
    markersArray = greenBuildings.concat(energyStarBuildings);
  } else if (buildingColor=='blue'){
    markersArray = grayBuildings.concat(greenBuildings);
  } else {
    markersArray.concat(greenBuildings).concat(energyStarBuildings).concat(grayBuildings);
    state = map;
  }
  for (var i = 0; i < markersArray.length; i++) {
    markersArray[i].setMap(state);
  }
}