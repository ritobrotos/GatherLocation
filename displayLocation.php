
	<?php 

		$con=mysqli_connect("localhost:3306","root","","gatherlocationdb");

		if (mysqli_connect_errno()) {
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		$result = mysqli_query($con,"SELECT * FROM locationrecord");
		while($row = mysqli_fetch_array($result)) {
		  echo $row['latitude'] . " " . $row['longitude'];
		  echo "<br>";
		}

		mysqli_close($con);
	?>
