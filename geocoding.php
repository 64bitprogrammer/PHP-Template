<!--
  This program uses Javascript, Google Maps API, jQuery
  and JSON in order to fetch location name via given
  coordinates using reverse geocoding
-->
<!DOCTYPE html>
<html>
<head>
  <script src="jquery-3.1.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>

  <div id="map" style="width:100%;height:500px"></div>

  <script>
  var url ='';
  // sets basic map parameters ,center of map and create 3 markers
  function myMap() {
    var myCenter = new google.maps.LatLng(51.508742,-0.120850);
    var mapCanvas = document.getElementById("map");
    var mapOptions = {center: myCenter, zoom: 5};
    var map = new google.maps.Map(mapCanvas, mapOptions);
    var marker = new google.maps.Marker({position:myCenter});
    marker.setMap(map);

    var newPos = new google.maps.LatLng(53.508742,-2.120850);
    var newPos2 = new google.maps.LatLng(48.508742,2.120850);

    placeMarkerAndWindow(map,newPos);
    placeMarkerAndWindow(map,newPos2);
  }


  function placeMarkerAndWindow(map,newPos){
    // set new marker
    var marker = new google.maps.Marker({
      position: newPos,
      map: map
    });
    // fetch location name and open infoWindow
    getAddress(newPos.lat(),newPos.lng(),map,marker);
  }

  function getAddress(lat,long,map,marker)
  {
    url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+long+'&sensor=true?';
    $.getJSON(url)
    .done (function(location)
    {
      // check javacript console for debugging
      console.log(location.results[0].formatted_address);
      var address = location.results[0].formatted_address;

      // Use following URL as reference in order to modify the search criteria such as city ,state , locality
      // http://maps.googleapis.com/maps/api/geocode/json?latlng=12.993015,77.661817&sensor=true


      // creates the new information on given marker with given address
      var infoWindow = new google.maps.InfoWindow({
        content: address
      });
      infoWindow.open(map,marker);
    });
  }


  </script>

  <script src="https://maps.googleapis.com/maps/api/js?callback=myMap"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<div id="country"></div>
</body>
</html>
