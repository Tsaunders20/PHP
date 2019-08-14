<html>
<head>
<?php
//Starting off with standard connection with sql, we'll use this to make a reactive dropdown for some of the stuff here
$host = "localhost";
$user = "root";
$password = "";
$db = "sykes_interview";

$conn = mysqli_connect($host, $user, $password, $db);

if(!$conn ) {
            die('Failed to connect to database');
         }
		 
		 ?>
</head>
<body>
<form action="results.php" method="post">
<!-- Form goes to a different page, could've done one on same page with enough time but not much points --->
Location:
<input type="text" name="location"/><br>

Near Beach: <input type="checkbox" name="beach" value="beach"><br>

Accepts Pets: <input type="checkbox" name="pets" value="pets"><br>

Minimum Sleeps: <?php

// Essensially what this is going to do is grab the highest sleeps in a property and make a drop down from 1 to whatever that number comes out as
// Probably should have left this in hindsight to do pagnation but hindsight

$sql = "SELECT * FROM properties ORDER BY sleeps DESC LIMIT 1";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

$highestsleeps = $row["sleeps"];

echo "<select name='sleeps'>";

for ($x = 1; $x <= $highestsleeps; $x++) {
    echo "<option value='$x'>$x</option>";
} 
//Standard for loop for it
echo "</select><br>";
?>
Beds: <?php

$sql = "SELECT MIN(beds) AS lowest,MAX(beds) AS highest FROM properties ORDER BY beds DESC";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

$lowestbeds = $row["lowest"];
$highestbeds = $row["highest"];


//Though i was being clever doing this but suppose doesnt make too much of a difference - in a different structure this would start at the lowest of the beds and list up to the highest like the last one does
echo "<select name='beds'>";

for ($x = $lowestbeds; $x <= $highestbeds; $x++) {
    echo "<option value='$x'>$x</option>";
} 
echo "</select><br>";
?>
From: 
<input type="date" name="from"><br>
To:
<input type="date" name="to"><br>
<input type="submit" value="Search">
</form>
</body>
</html>