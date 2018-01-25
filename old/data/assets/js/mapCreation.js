// This js script will create a google map and insert it in the corresponding HTML element
var map;
function initialize() {
    var mapOptions = {
		center: new google.maps.LatLng(37.068427, -80.089019),
        zoom: 6,
        styles: [{featureType: "poi", elementType: "labels", stylers: [{visibility: "off" }]}]
    };
    map = new google.maps.Map(d3.select('#map-canvas').node(),
        mapOptions);
}
// Adds the map to the dom when the page has loaded
google.maps.event.addDomListener(window, 'load', initialize);