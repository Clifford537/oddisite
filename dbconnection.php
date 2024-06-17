<?php
// Database configuration
$servername = "localhost";  
$username = "root";     
$password = "GCEPC3_M_aBWssB";     
$dbname = "colloh_shop";  
$port = 3306;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname,$port );

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
