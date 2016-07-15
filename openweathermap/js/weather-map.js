/**
 * @file
 * Contains the definition of the behaviour weather map.
 */
jQuery(document).ready(function() {
    "use strict";
    //Center  ( mercator coordinates ) Minsk
    var lat = 53.900002;
    var lon = 27.566668;

    //if  you use WGS 1984 coordinate you should  convert to mercator
    // 	lonlat.transform(
    // 		new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
    // 		new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
    // 	);

    var lonlat = new OpenLayers.LonLat(lon, lat);
    lonlat.transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
    );
    
    //map size declares in element description
    var width = drupalSettings.weather_map.width;
    var height = drupalSettings.weather_map.height;
    
    jQuery('#basicMap').width(width).height(height);

    // Create overlays
    // map layer OSM
    var map = new OpenLayers.Map("basicMap");

    var mapnik = new OpenLayers.Layer.OSM();
    // Create station layer
    var stations = new OpenLayers.Layer.Vector.OWMStations("Stations");
    // Create weather layer 
    var city = new OpenLayers.Layer.Vector.OWMWeather("Weather");
    
    //connect layers to map
     map.addLayers([mapnik, stations, city]);

    //Add Layers swither
    map.addControl(new OpenLayers.Control.LayerSwitcher());

    map.setCenter( lonlat, 10 );

    // Add popups for weather description
    var selectControl = new OpenLayers.Control.SelectFeature([city,stations]);
    map.addControl(selectControl);
    selectControl.activate();
});

