<?php
	$id = $_POST['id'];
	
	// Database connection
	$conn = new mysqli('localhost','root','','gp_shuttle_db');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	}
	else {
		$stmt = $conn->prepare("insert into users(id) values(?)");
		$stmt->bind_param("i", $id);
		$execval = $stmt->execute();
		$stmt->close();
		$conn->close();
	}
	$url = ("DriverOrRider.html?id=" . $id);
	header('Location: ' . $url);
?>