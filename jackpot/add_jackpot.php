<?php
// Start session (if not already started)
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    // Redirect to login page if not logged in
    header("Location: ../login.php");
    exit();
}

// Continue with your existing code
include '../dbconnection.php';

// Initialize variables to store form data
$jackpottype_id = $_POST['jackpottype_id'];
$team1 = $_POST['team1'];
$team2 = $_POST['team2'];
$win = $_POST['win'];
$date_played = $_POST['date_played'];

// Prepare SQL query to insert data into `jackpots` table using prepared statement for security
$stmt = $conn->prepare("INSERT INTO jackpots (jackpottype_id, team1, team2, win, date_played) 
                        VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $jackpottype_id, $team1, $team2, $win, $date_played);

// Execute statement
if ($stmt->execute()) {
    echo "New jackpot record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>
