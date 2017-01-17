
<html>

<body>

<div id="map" style="width:100%;height:500px"></div>

<script>
function myMap() {
  var myCenter = new google.maps.LatLng(51.508742,-0.120850);
  var mapCanvas = document.getElementById("map");
  var mapOptions = {center: myCenter, zoom: 1};
  var map = new google.maps.Map(mapCanvas, mapOptions);
  var marker = new google.maps.Marker({position:myCenter});
  marker.setMap(map);





  var newPos = myCenter;
    var marker = new google.maps.Marker({
        position: newPos,
        map: map
      });
 var infowindow = new google.maps.InfoWindow({
        content: 'Latitude: ' + $latitude + '<br>Longitude: ' + $longitude
      });
      infowindow.open(map,marker);

</script>

<script src="https://maps.googleapis.com/maps/api/js?callback=myMap"></script>

</body>
</html>
