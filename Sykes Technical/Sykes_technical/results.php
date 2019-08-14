<?php

$location = $_POST["location"];





if( isset($_POST["beach"]) )
{
     $nearbeach = 1;
}
else{
	$nearbeach = 0;
}

if( isset($_POST["pets"]) )
{
     $pets = 1;
}
else{
	$pets = 0;
}

$sleeps = $_POST["sleeps"];

$beds = $_POST["beds"];

$from = $_POST["from"];

$to = $_POST["to"];


$host = "localhost";
$user = "root";
$password = "";
$db = "sykes_interview";

$conn = mysqli_connect($host, $user, $password, $db);

if(!$conn ) {
            die('Failed to connect to database');
         }
$query = "SELECT location_name,
properties.property_name,
CASE WHEN properties.accepts_pets = 1 THEN 'Allows Pets' ELSE 'No pets' END AS pets,
CASE WHEN properties.near_beach = 1 THEN 'Near the beach' ELSE 'In land' END AS sea,
properties.sleeps,
properties.beds
FROM locations 
INNER JOIN properties 
ON locations.__pk = properties._fk_location";

// Essensially a standard select for now - using the case when to create our strings for later, means we dont have to use a ton of nested ifs

//Joined to properties so we can get our information printed from there
if($pets == 1){
	$query.=" AND accepts_pets = 1";
}
if($nearbeach == 1){
	$query.=" AND near_beach = 1";
}
//In hind sight could  have been sneaky and put a >= instead to cover bases if they dont care
$query.= " AND sleeps >= '$sleeps' AND beds >= '$beds'";

if( isset($_POST["start"]) && isset($_POST["end"]) )
{
$query.="INNER JOIN bookings
 ON '$from' NOT BETWEEN bookings.start_date AND bookings.end_date 
 AND '$to' NOT BETWEEN bookings.start_date AND bookings.end_date ";
 
 //Didnt fully test this to be honest but just a not between so can be sure of things, probably needs to be more complicated to be completely effective
 
}
$query.=" WHERE location_name LIKE '%$location%'";
//echo $query;
         $result = mysqli_query($conn, $query);
		 
		 $num_rows = mysqli_num_rows ( $result );
		 $current = 1;
		 if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
				echo "<div class='outputs'>";
               echo "Name: " . $row["property_name"]. "<br>" ;
			   echo "Location: " . $row["location_name"]. "<br>" ;
			   echo $row["pets"]. "<br>" ;
			   echo $row["sea"]. "<br>" ;
			   echo "Location: " . $row["beds"]. " beds<br>" ;
			   echo "Location: " . $row["sleeps"]. " sleeps<br>" ;
			   echo "</div>";
			   if($num_rows > 1){
				   echo "<div class='selecter'>$current</div>";
				   
				   // Didn't get time to both comment and do this but this would have been my pagnation
			   }
			   $current++;
            }
         } else {
            echo "0 results";
         }
         mysqli_close($conn);
?>