<?php
	$footer = htmlspecialchars($_GET["id"]);
	$cadetid = $_POST['cadetid'];

	// Create connection
	$conn = new mysqli('localhost','root','','gp_shuttle_db');
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
  
	// sql to delete a record
	$sql = "DELETE FROM rides";

	if ($conn->query($sql) === TRUE) {
	  echo "Record deleted successfully";
	} else {
	  echo "Error deleting record: " . $conn->error;
	}

$conn->close();

	$url = ("driveaction.php?id=" . $footer);
	header('Location: ' . $url);
?>