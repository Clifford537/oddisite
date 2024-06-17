<?php
// Include database connection script
require_once 'dbconnection.php';

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $plan_id = mysqli_real_escape_string($conn, $_POST['plan_id']);
    $team1 = mysqli_real_escape_string($conn, $_POST['team1']);
    $team2 = mysqli_real_escape_string($conn, $_POST['team2']);
    $odds_team1 = mysqli_real_escape_string($conn, $_POST['odds_team1']);
    $odds_team2 = mysqli_real_escape_string($conn, $_POST['odds_team2']);
    $win_team = mysqli_real_escape_string($conn, $_POST['win_team']);

    // Attempt insert query execution
    $sql = "INSERT INTO matches (plan_id, team1, team2, odds_team1, odds_team2, win_team)
            VALUES ('$plan_id', '$team1', '$team2', '$odds_team1', '$odds_team2', '$win_team')";

    if (mysqli_query($conn, $sql)) {
        echo "Match added successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>
