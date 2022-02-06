<?php	
// Create connection
$conn = new mysqli('localhost','root','','gp_shuttle_db');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$riderid = htmlspecialchars($_GET["id"]);

$sql = "SELECT * FROM rides";
$result = $conn->query($sql);

$rides = array();
$counter = 0;
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    //echo "id: " . $row["id"]. "<br>";
  $rides[$counter] = array("Cadet #" . $row["id"] . " Ride ID: " . $row["rideid"] . " Time: " . $row["time"] . " Date: " . $row["date"] . " at " . $row["location"] . ". " , $row["time"], $row["date"], $row["rideid"], $row["completed"]);
  $counter++;
  }
} else {
}
$conn->close();
?>

<html>

<head>
	<title>GP Shuttle Rides</title>
	<script type="text/javascript" src="scripts.js">
	</script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="icon" href="https://www.logolynx.com/images/logolynx/93/9312a1df88375cac1bca083385362d88.jpeg">
</head>

<body>
<div class="container2">	
<h1>Welcome GP Shuttle Driver</h1>
<?php echo("<h1>Total Rides: </h1>");?>

  <ul><?php 
	$lowesttime = 2400;
	$y = 0;
	$lowestride = 0;
	$printed = "";
	$printedid= "";
	//code to print in order of dates and timetime
	while ($y < $counter) {
		$date = $rides[$y][2];

		if ($rides[$y][2] != "") {
			if ($printed != $rides[$y][2]) {
					echo "<h2>for Date: $date</h2>";
					$printed = $date;
			}
		}
		$x = 0;
		while ($x < $counter) {
			if ($rides[$x][2] == $date) {
				if (($rides[$x][3] != $printedid)) {
					$z = 0;
					$lowesttime = 2400;
					for ($z = 0; $z < $counter; $z++) {
						if ($rides[$z][1] < $lowesttime) {
							if ($rides[$z][2] == $date) {
							$time = $rides[$z][1];
								$lowesttime = $rides[$z][1];
								$lowestride = $z;
							}
						}
					}
					$rides[$lowestride][1] = 2400;
					$boost = 0;
					if ($printedid == $rides[$lowestride][3]) {
						$boost = true;
					}
					if ($boost == 0) {
						echo"<li>";
						echo($rides[$lowestride][0]);	
						echo "<br>";
						$printedid = ($rides[$lowestride][3]);
					}
				}
				
			}
			$x++;
		}
		$y++;
	}
	?></ul>
	
<fieldset id="editenterIDFieldset" style="display:none">
    <p>Enter a ride id to edit<p>
    <input id="rideID"></input>
    <button onClick="editcheckIDFunction()">Submit</button>
</fieldset>

<fieldset id="completeenterIDFieldset" style="display:none">
    <p>Enter a ride id to complete<p>
	<form action="deleteridedriverversion.php?id=<?php  echo $riderid ?>" method="post">
    <input type="text" id="rideid" name="rideid"required></input>
    <button class="button" onClick="deletecheckIDFunction()">Submit</button>
	</form>
</fieldset>

<fieldset id="deleteenterIDFieldset" style="display:none">
    <p>Enter a ride id to delete<p>
	<form action="deleteridedriverversion.php?id=<?php  echo $riderid ?>" method="post">
    <input type="text" id="rideid" name="rideid"required></input>
    <button class="button" onClick="deletecheckIDFunction()">Submit</button>
	</form>
</fieldset>

<fieldset id="deleteallenterIDFieldset" style="display:none">
    <p>Enter a cadet id to delete all rides<p>
	<form action="deleteallcadetrides.php?id=<?php  echo $riderid ?>" method="post">
    <input type="text" id="cadetid" name="cadetid"required></input>
    <button class="button" onClick="deleteallcadetidFunction()">Submit</button>
	</form>
</fieldset>

<fieldset id="deleteallFieldset" style="display:none">
    <p>Are you sure you want to delete all rides?<p>
	<form action="deleteallrides.php?id=<?php  echo $riderid ?>" method="post">
    <button class="button" onClick="deleteallFunction()">Submit</button>
	</form>
</fieldset>

  <div> 
      <button class="button" onclick="completeFunction()">Complete</button>
      <button class="button" onclick="deleteFunction()">Delete</button>
	  <br></br>
	  <button class="button" onclick="deleteallcadetidFunction()">Delete all for a cadet</button>
	  <button class="button" onclick="deleteallFunction()">Delete all rides</button>

 </div>
  <p> </p>
  <button class="button" onclick="returnFunction()">Return to Log In Page</button>
 
<!--Script below extracts rides from database, and displays them for selection by user. If there are no rides, it displays no rides. -->
  <script>
  var queryString = location.search.substring(1);
   
  var ul = document.querySelector("ul");
  for (var i = 0; i < rides.length; i++) {
    var ride = rides[i];
    var listItem = document.createElement("label");
    listItem.textContent = ride;

    var checkBox = document.createElement("input");
    checkBox.type = "radio";
    checkBox.name = "radiobutton";
    checkBox.id = i;

    var li = document.createElement("li");
    li.appendChild(checkBox);
    li.appendChild(listItem);
    ul.appendChild(li);
  }

    if(document.getElementById('radiobuttonid').checked) {
      var selectLabel = document.createElement("label");
      selectedLabel.textContent = "selected";
      ul.appendChild(selectedLabel);
    }
  
  function completeFunction() {
	document.getElementById("deleteallFieldset").style.display = "none";  
	document.getElementById("deleteenterIDFieldset").style.display = "none"; 
    document.getElementById("deleteallenterIDFieldset").style.display = "none";  
	document.getElementById("completeenterIDFieldset").style.display = "block"; 
  }
  function deleteFunction() {
	document.getElementById("deleteallFieldset").style.display = "none";  
	document.getElementById("completeenterIDFieldset").style.display = "none"; 
	document.getElementById("deleteallenterIDFieldset").style.display = "none";  
	document.getElementById("deleteenterIDFieldset").style.display = "block"; 
 }
    function deleteallcadetidFunction() {
	document.getElementById("deleteallFieldset").style.display = "none";  
	document.getElementById("completeenterIDFieldset").style.display = "none"; 
	document.getElementById("deleteenterIDFieldset").style.display = "none"; 
	document.getElementById("deleteallenterIDFieldset").style.display = "block";  
  }
  
  function deleteallFunction() {
	document.getElementById("completeenterIDFieldset").style.display = "none"; 
	document.getElementById("deleteenterIDFieldset").style.display = "none"; 
	document.getElementById("deleteallenterIDFieldset").style.display = "none";  
	document.getElementById("deleteallFieldset").style.display = "block";  
  }
  
  function submitinfoFunction() {
    var timeinput=document.getElementById("timeInput").value;
    var dateinput=document.getElementById("dateInput").value;
    var locationinput=document.getElementById("locationInput").value;
    if (timeinput==="" || dateinput==="" || locationinput===""){
      document.getElementById("fieldsnotfilledWarning").style.display = "block";
    }
    else {
      document.getElementById("fieldsnotfilledWarning").style.display = "none";
	  location = "RiderMenu.html?id=" + queryString;
    }
  }
  
  function addcheckIDFunction() {
	location = "addride.php?" + queryString;
  }
	  
  function deletecheckIDFunction() {
	location = "deleteridedriverversion.php?" + queryString;
  }
  
  function returnFunction() {
    location = "index.html";
  }
  </script>
  </div>
</body>

</html>