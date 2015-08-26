function initLegend(map) {
    // List of legend labels.
    labels = new Array('Energy Star Buildings', 'Large buildings', 'Small Buildings');
    // List of legend icons
    icons = new Array('images/energy_star_logo_small.png', 'images/measle_blue.png', 'images/green_circle_icon_md_20px.png');
    var legend = document.getElementById('legend');
    for (i = 0; i < labels.length; i++) {
      var div = document.createElement('div');
      div.id = "legendItem" + i;
      legend.appendChild(div);
      var template = $('#legend_item').html();
      Mustache.parse(template);   // optional, speeds up future uses
      var rendered = Mustache.render(template, {icon: icons[i], label: labels[i]});  
      $("#legendItem" + i).html(rendered);
    }

    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(legend);
}