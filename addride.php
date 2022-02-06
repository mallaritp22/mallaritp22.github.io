<?php
	$footer = htmlspecialchars($_GET["id"]);
	$rideid = "";
	$id = $footer;
	$time = $_POST['time'];
	$date = $_POST['date'];
	$location = $_POST['location'];
	$completed = 0;

	// Database connection
	$conn = new mysqli('localhost','root','','gp_shuttle_db');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into rides(rideid, id, time, date, location, completed)values(?,?,?,?,?,?)");
		$stmt->bind_param("iisssi", $rideid, $id, $time, $date, $location, $completed);
		$execval = $stmt->execute();
		$stmt->close();
		$conn->close();
	}
	$url = ("rideaction.php?id=" . $footer);
	header('Location: ' . $url);
?>