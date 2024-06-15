<!-- dbconnection.php -->

<?php
// Database configuration
$servername = "localhost";  // Change if your database server is different
$username = "root";     // Replace with your MySQL username
$password = "";     // Replace with your MySQL password
$dbname = "oddshop";  // Replace with your MySQL database name
$port = 3306;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname,$port );

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
