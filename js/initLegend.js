function initLegend(map) {
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
}