<?php
// Include database connection or initialization script here
include '../dbconnection.php';

// Fetch jackpottypes from the database
$query = "SELECT id, type FROM jackpottypes";
$result = $conn->query($query);

$jackpottypes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jackpottypes[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Jackpot</title>
</head>
<body>
    <h2>Add Jackpot</h2>
    <form action="add_jackpot.php" method="post">
        <label for="jackpottype">Jackpot Type:</label><br>
        <select id="jackpottype" name="jackpottype_id" required>
            <?php foreach ($jackpottypes as $jackpottype): ?>
                <option value="<?= htmlspecialchars($jackpottype['id']) ?>"><?= htmlspecialchars($jackpottype['type']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="team1">Team 1:</label><br>
        <input type="text" id="team1" name="team1" required><br><br>

        <label for="team2">Team 2:</label><br>
        <input type="text" id="team2" name="team2" required><br><br>

        <label for="win">Winning Team/Outcome:</label><br>
        <input type="text" id="win" name="win" required><br><br>

        <label for="date_played">Date Played:</label><br>
        <input type="date" id="date_played" name="date_played" required><br><br>

        <input type="submit" value="Add Jackpot">
    </form>
</body>
</html>
