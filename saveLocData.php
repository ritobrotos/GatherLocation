<?php 
	$phoneid = urldecode($_GET["phoneId"]);
	$lat = urldecode($_GET["latitude"]);
	$long = urldecode($_GET["longitude"]);
	$phonetime = urldecode($_GET["phoneTimestamp"]);

	$con=mysqli_connect("localhost:3306","root","","gatherlocationdb");

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	echo "latitude :: " . $lat . ", longitude :: " . $long . "<br>";
	echo "Date ::: " . $phonetime;

	mysqli_query($con,"INSERT INTO locationrecord (latitude, longitude, phoneid, phonerecordDt)
			VALUES (" . $lat . ", " . $long . ",'" . $phoneid ."','". $phonetime  . "')");

	mysqli_close($con);
?>
