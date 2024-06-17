<?php
session_start();

// Include database connection
include 'dbconnection.php';

// Check if user is logged in and is admin or superadmin
if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    header("Location: login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $plan_id = mysqli_real_escape_string($conn, $_POST['plan_id']);
    $team1 = mysqli_real_escape_string($conn, $_POST['team1']);
    $team2 = mysqli_real_escape_string($conn, $_POST['team2']);
    $odds_team1 = mysqli_real_escape_string($conn, $_POST['odds_team1']);
    $odds_team2 = mysqli_real_escape_string($conn, $_POST['odds_team2']);
    $win_team = mysqli_real_escape_string($conn, $_POST['win_team']);
    $date_played = mysqli_real_escape_string($conn, $_POST['date_played']);

    // Validate data (you can add more specific validation as needed)
    if (empty($plan_id) || empty($team1) || empty($team2) || empty($odds_team1) || empty($odds_team2) || empty($win_team) || empty($date_played)) {
        // Handle empty fields case
        echo '<div class="alert alert-danger" role="alert">All fields are required!</div>';
    } else {
        // Prepare SQL statement for insertion
        $sql_insert = "INSERT INTO matches (plan_id, team1, team2, odds_team1, odds_team2, win_team, date_played) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("issssss", $plan_id, $team1, $team2, $odds_team1, $odds_team2, $win_team, $date_played);

        // Execute the statement
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Match added successfully!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error adding match: ' . $conn->error . '</div>';
        }

        // Close statement
        $stmt->close();
    }
}

// Close database connection
$conn->close();
?>
