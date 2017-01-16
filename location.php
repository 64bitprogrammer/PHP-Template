<?php

require_once('connect.php');
mysqli_select_db($conn,'lt');

$result = mysqli_query($conn,"select Lat,Lng from profiles");

?>
<html>
<head>

<script src="jquery-3.1.1.min.js"></script>
</head>

<body>

<div id="map" style="width:100%;height:500px"></div>

<script>
var fullAddress;
function myMap() {
  var myCenter = new google.maps.LatLng(51.508742,-0.120850);
  var mapCanvas = document.getElementById("map");
  var mapOptions = {center: myCenter, zoom: 1};
  var map = new google.maps.Map(mapCanvas, mapOptions);
  var marker = new google.maps.Marker({position:myCenter});
  marker.setMap(map);

  <?php
  $i=0;
  while($row = mysqli_fetch_assoc($result) and $i<=10){
    $latitude = $row['Lat'];
    $longitude = $row['Lng'];
    if($latitude!='0' && $longitude!='0' ){
      echo "var newPos = new google.maps.LatLng($latitude,$longitude);";
      echo 'var marker = new google.maps.Marker({
        position: newPos,
        map: map
      }); ';
      echo " getAddress(newPos.lat(),newPos.lng(),map,marker);";
    }
    $i++;
  }
  ?>
}
function getAddress(lat,long,map,marker)
{
  url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+long+'&sensor=true?';
  $.getJSON(url)
           .done (function(location)
           {

              console.log(location.results[0].formatted_address);
              var address = location.results[0].formatted_address;
              var infoWindow = new google.maps.InfoWindow({
                content: address
                });
                infoWindow.open(map,marker);
           });
}
</script>


<script src="https://maps.googleapis.com/maps/api/js?callback=myMap"></script>
</body>
</html>
