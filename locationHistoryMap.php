<?php
  $con=mysqli_connect("localhost:3306","root","","gatherlocationdb");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $imei = urldecode($_POST["imei"]);
    $result = mysqli_query($con,"select * from locationrecord where isDelete='N' and phoneid=" . $imei . " order by locationrecordid");
    
      //$lat = $row['latitude'];
      //$long = $row['longitude'];
    
?>
<html>
<head>
  <title>Trace Location</title>
  <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
  </style>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
  <script type="text/javascript">
    var locationHis = new Array();
    var latLong = new Array();
    var lastLatitude = 0, lastLongitude = 0;
    var routePath = new Array();
    var bounds = new google.maps.LatLngBounds();
    <?php 
      while($row = mysqli_fetch_array($result)) {
    ?>
        latLong[0] = <?php echo $row['latitude']; ?>;
        latLong[1] = <?php echo $row['longitude']; ?>;

        if(locationHis.length > 0){
          //lastLatitude = locationHis[locationHis.length-1][0];
          //lastLongitude = locationHis[locationHis.length-1][1];
          if(lastLatitude==latLong[0] && lastLongitude==latLong[1]){
            // do nothing
            //alert(lastLatitude + ' :::  ' + latLong[0] + " ::::>>> " + locationHis[0]);
            //alert(locationHis[0]);
          }else{
            lastLatitude = latLong[0];
            lastLongitude = latLong[1];
            var googleLatLong = new google.maps.LatLng(latLong[0], latLong[1])
            routePath.push(googleLatLong);
            bounds.extend(googleLatLong);
            locationHis.push(latLong);
          }
        } else {
          lastLatitude = latLong[0];
          lastLongitude = latLong[1];
          var googleLatLong = new google.maps.LatLng(latLong[0], latLong[1])
          routePath.push(googleLatLong);
          bounds.extend(googleLatLong);
          locationHis.push(latLong);
        }
    <?php 
      } 
      mysqli_close($con);
    ?>
    //alert(locationHis.length);
    function initialize() {
  // var myLatlng = new google.maps.LatLng(19.109214, 72.854521);
      //var myLatlng = new google.maps.LatLng(locationHis[0][0], locationHis[0][1]);
      var myLatlng = routePath[0];
      var mapOptions = {
        center: myLatlng
      }
      var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

      var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: 'Hello World!'
      });
      //alert(myLatlng);

      //alert("path :: " + routePath.length);
      //console.log(routePath);
      var poly = new google.maps.Polyline({
        icons : [ {
          icon : {
            path : google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
            strokeColor : '#037FFF',
            fillColor : '#037FFF',
            scale : 2,
            fillOpacity : 1
          },
          repeat : '100px',
          path : []
        } ],
        path: routePath,
        geodesic: true,
        strokeColor: '#037FFF',
        strokeOpacity: 1.0,
        strokeWeight: 2
      });
      //poly.setPath(path);
      poly.setMap(map);
      map.fitBounds(bounds);

      for(var i=1; i<routePath.length; i++){
        var marker = new google.maps.Marker({
            position: routePath[i],
            map: map,
            icon : 'img/images.jpg',
            title: 'Location Points'
        });
      }
    }

    google.maps.event.addDomListener(window, 'load', initialize);
  </script>

</head>
<body>
  <div id="map-canvas"></div>
</body>
</html>
