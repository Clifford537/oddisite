<?php

session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {

    header("Location: ../login.php");
    exit();
}


$isSuperadmin = ($_SESSION['usertype'] === 'SU');
$isAdmin = ($_SESSION['usertype'] === 'Admin');
$isUser = ($_SESSION['usertype'] === 'User');
?>
<?php include './layout/header.php'; ?>
<body>
    <h1>Add a New Match</h1>
    <form action="match_add.php" method="post">
        <label for="type">Match Type:</label><br>
        <select id="type" name="type" required>
            <option value="">Select Match Type</option>
            <?php
            include 'dbconnection.php';
            $sql = "SELECT type FROM matchtype";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['type'] . "'>" . $row['type'] . "</option>";
                }
            } else {
                echo "<option value=''>No Match Types Available</option>";
            }
            $conn->close();
            ?>
        </select><br><br>
        
        <label for="team_1">Team 1:</label><br>
        <input type="text" id="team_1" name="team_1" required><br><br>
        
        <label for="team_2">Team 2:</label><br>
        <input type="text" id="team_2" name="team_2" required><br><br>
        
        <label for="team_1_odds">Team 1 Odds:</label><br>
        <input type="number" step="0.01" id="team_1_odds" name="team_1_odds" required><br><br>
        
        <label for="team_2_odds">Team 2 Odds:</label><br>
        <input type="number" step="0.01" id="team_2_odds" name="team_2_odds" required><br><br>
        
        <label for="winteam">Winning Team:</label><br>
        <input type="text" id="winteam" name="winteam" required><br><br>
        
        <label for="match_date">Match Date:</label><br>
        <input type="date" id="match_date" name="match_date" required><br><br>
        
        <input type="submit" value="Add Match">
    </form>
    <?php include './layout/footer.php'; ?>
