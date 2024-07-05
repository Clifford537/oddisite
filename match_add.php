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
include 'dbconnection.php';

$type = $_POST['type'];
$team_1 = $_POST['team_1'];
$team_2 = $_POST['team_2'];
$team_1_odds = $_POST['team_1_odds'];
$team_2_odds = $_POST['team_2_odds'];
$winteam = $_POST['winteam'];
$match_date = $_POST['match_date'];

$sql = "INSERT INTO matches (type, team_1, team_2, team_1_odds, team_2_odds, winteam, match_date)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssddss", $type, $team_1, $team_2, $team_1_odds, $team_2_odds, $winteam, $match_date);

if ($stmt->execute()) {
    echo "New match added successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
