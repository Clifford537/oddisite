<?php
// Include database connection script
include '../dbconnection.php';

// Initialize variables to store form data
$jackpottype_id = $_POST['jackpottype_id'];
$team1 = $_POST['team1'];
$team2 = $_POST['team2'];
$win = $_POST['win'];
$date_played = $_POST['date_played'];

// Prepare SQL query to insert data into `jackpots` table
$query = "INSERT INTO jackpots (jackpottype_id, team1, team2, win, date_played) 
          VALUES ('$jackpottype_id', '$team1', '$team2', '$win', '$date_played')";

// Execute query
if ($conn->query($query) === TRUE) {
    echo "New jackpot record created successfully";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>
