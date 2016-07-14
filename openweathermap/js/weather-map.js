jQuery(document).ready(function() {

//     // for OSM layer

    var map;
    //Center  ( mercator coordinates )
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



    map = new OpenLayers.Map("basicMap");


    var mapnik = new OpenLayers.Layer.OSM();



    var stations = new OpenLayers.Layer.Vector.OWMStations("Stations");


    var city = new OpenLayers.Layer.Vector.OWMWeather("Weather");


     map.addLayers([mapnik, stations, city]);
    //
    //

    //Add Layers swither
    map.addControl(new OpenLayers.Control.LayerSwitcher());

    map.setCenter( lonlat, 10 );

    // Add popups
    selectControl = new OpenLayers.Control.SelectFeature([city,stations]);
    map.addControl(selectControl);
    selectControl.activate();





});

