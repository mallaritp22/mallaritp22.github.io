<?php	
// Create connection
$conn = new mysqli('localhost','root','','gp_shuttle_db');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$riderid = htmlspecialchars($_GET["id"]);

$sql = "SELECT * FROM rides WHERE id =" . $riderid;
$result = $conn->query($sql);

$rides = array();
$counter = 0;
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    //echo "id: " . $row["id"]. "<br>";
  $rides[$counter] = array("Ride #" . ($counter+1) . " Ride ID: " . $row["rideid"] . " Time: " . $row["time"] . " Date: " . $row["date"] . " at " . $row["location"]);
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

	<meta charset="utf-8">
</head>

<body>
<div class="container2">
<?php echo("<h1> Rides for Cadet # $riderid </h1>");
echo "<br>";?>

  <ul><?php 
	for ($x = 0; $x < $counter; $x++) {
		echo"<li>";
		echo($rides[$x][0]);
		echo "<br>";
	}
	?></ul>
	
<fieldset id="editenterIDFieldset" style="display:none">
    <p>Enter a ride id to edit<p>
    <input id="rideID"></input>
    <button onClick="editcheckIDFunction()">Submit</button>
</fieldset>

<fieldset id="deleteenterIDFieldset" style="display:none">
    <p>Enter a ride id to delete<p>
	<form action="deleteride.php?id=<?php  echo $riderid ?>" method="post">
    <input type="text" id="rideid" name="rideid"required></input>
    <button onClick="deletecheckIDFunction()">Submit</button>
	</form>
</fieldset>


  <fieldset id="showEditPanel"style="display:none;">
  <form action="addride.php?id=<?php  echo $riderid ?>"method="post">
    <p>Enter a time (2400 format)</p>
    <input type="text" id="time" name="time"required></input>
    <p>Enter a date (01/01/2000 format)</p>
    <input type="text" id="date" name="date"required></input>
	<p>Enter a pickup location (ex. Salerno's)</p>
    <input type="text" id="location" name="location"required></input>
	<br></br>
    <button class="button" onClick="addcheckIDFunction()">Submit</button>
	</form>
  </fieldset>

  <div> 
      <button class="button" onclick="addFunction()">Add</button>
      <button class="button" onclick="deleteFunction()">Delete</button>
  </div>
  <p> </p>
  <button class="button"onclick="returnFunction()">Return</button>
 
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
  
  function addFunction() {
    document.getElementById("showEditPanel").style.display = "block"; 
	document.getElementById("deleteenterIDFieldset").style.display = "none"; 
  }
  function editFunction() {
	document.getElementById("deleteenterIDFieldset").style.display = "none"; 
	document.getElementById("editenterIDFieldset").style.display = "block"; 
  }
  function deleteFunction() {
	document.getElementById("showEditPanel").style.display = "none"; 
	document.getElementById("deleteenterIDFieldset").style.display = "block"; 
	document.getElementById("editenterIDFieldset").style.display = "none"; 
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
	location = "deleteride.php?" + queryString;
  }
  
  function returnFunction() {
    location = "RiderMenu.html?" + queryString;
  }
  </script>
  </div>
</body>

</html>