<?php
?>

<!DOCTYPE html>
<html>
<head>


</head>
<body>
  <div id="map" style="width:100%;height:500px;background:yellow">
<script>
// function myMap() {
// var myCenter = new google.maps.LatLng(12.989102,77.663414);
// var mapCanvas = document.getElementById("map");
// var mapOptions = {center: myCenter, zoom: 15};
// var map = new google.maps.Map(mapCanvas, mapOptions);
// var marker = new google.maps.Marker({position:myCenter,animation:google.maps.Animation.BOUNCE});
// //icon:'pinkball.png'
// marker.setMap(map);
// }

function myMap() {
  var belgaum = new google.maps.LatLng(15.867411, 74.511494);
  var bangalore = new google.maps.LatLng(12.989102,77.663414);
  var dehli = new google.maps.LatLng(28.633342, 77.204165);

  var mapCanvas = document.getElementById("map");
  var mapOptions = {center: belgaum, zoom: 4};
  var map = new google.maps.Map(mapCanvas,mapOptions);

  var flightPath = new google.maps.Polygon({
    path: [belgaum, bangalore, dehli],
    strokeColor: "#d82b4e",
    strokeOpacity: 0.8,
    strokeWeight: 2,
    editable: false
  });
  flightPath.setMap(map);
}
</script>


<script src="https://maps.googleapis.com/maps/api/js?key=&callback=myMap"></script>
</body>
<html>
