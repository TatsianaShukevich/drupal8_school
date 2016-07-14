jQuery(document).ready(function() {
    //another map
    //Center of map
    //var lonlat = new OpenLayers.LonLat(27.566668, 53.900002);

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

    var map = new OpenLayers.Map("tileMap");
    // Create OSM overlays
    var mapnik = new OpenLayers.Layer.OSM();

    var layer_cloud = new OpenLayers.Layer.XYZ(
        "clouds",
        "http://${s}.tile.openweathermap.org/map/clouds/${z}/${x}/${y}.png",
        {
            isBaseLayer: false,
            opacity: 0.7,
            sphericalMercator: true
        }
    );


    var layer_precipitation = new OpenLayers.Layer.XYZ(
        "precipitation",
        "http://${s}.tile.openweathermap.org/map/precipitation/${z}/${x}/${y}.png",
        {
            isBaseLayer: false,
            opacity: 0.7,
            sphericalMercator: true
        }
    );


    map.addLayers([mapnik, layer_precipitation, layer_cloud]);

});


