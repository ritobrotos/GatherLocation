<!DOCTYPE html>
<?php 
    $con=mysqli_connect("localhost:3306","root","","gatherlocationdb");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $result = mysqli_query($con,"SELECT * FROM locationrecord order by locationrecordid desc limit 1");
    while($row = mysqli_fetch_array($result)) {
      $lat = $row['latitude'];
      $long = $row['longitude'];
    }

    mysqli_close($con);
?>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Current Location Map</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
function initialize() {
  // var myLatlng = new google.maps.LatLng(19.109214, 72.854521);
  var myLatlng = new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $long; ?>);
  var mapOptions = {
    zoom: 6,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Hello World!'
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

