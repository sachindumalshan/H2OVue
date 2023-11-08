<?php
 
$hostname = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "water_bill_mgt_system"; 

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) { 
	die("Connection failed: " . mysqli_connect_error()); 
} 

echo "Database connection is OK"; 

if(isset($_POST["flowread"]) ) {

	$t = $_POST["flowread"];

	$sql = "INSERT INTO liquid_quantity (flowread) VALUES (".$t.")"; 

	if (mysqli_query($conn, $sql)) { 
		echo "\nNew record created successfully"; 
	} else { 
		echo "Error: " . $sql . "<br>" . mysqli_error($conn); 
	}
}

?>