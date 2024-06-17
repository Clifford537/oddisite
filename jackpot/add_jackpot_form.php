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

<?php
// Include the header file
include '../layout/header.php';
?>

    <h2 class="form-heading">Add Jackpot</h2>
    <form action="add_jackpot.php" method="post" class="register-form">
        <label for="jackpottype">Jackpot Type:</label>
        <select id="jackpottype" name="jackpottype_id" required>
            <?php foreach ($jackpottypes as $jackpottype): ?>
                <option value="<?= htmlspecialchars($jackpottype['id']) ?>"><?= htmlspecialchars($jackpottype['type']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="team1">Team 1:</label>
        <input type="text" id="team1" name="team1" required>

        <label for="team2">Team 2:</label>
        <input type="text" id="team2" name="team2" required>

        <label for="win">Winning Team/Outcome:</label>
        <input type="text" id="win" name="win" required>

        <label for="date_played">Date Played:</label>
        <input type="date" id="date_played" name="date_played" required>

        <input type="submit" value="Add Jackpot">
    </form>

<?php
// Include the footer file
include '../layout/footer.php';
?>
