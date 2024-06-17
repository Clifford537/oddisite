<?php include './layout/header.php'; ?>

<h2 class="text-center mt-4 mb-4">Add Match</h2>
<div class="container">
    <form action="match_add.php" method="POST">
        <label for="plan_id">Select Plan:</label>
        <select id="plan_id" name="plan_id" class="form-control mb-2" required>
            <?php
            // Include database connection script
            require_once 'dbconnection.php';

            // Fetch plans from the database
            $query = "SELECT id, name FROM plans";
            $result = mysqli_query($conn, $query);

            // Check if any rows were returned
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    // Loop through results and create options for dropdown
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No plans available</option>";
                }
                // Free result set
                mysqli_free_result($result);
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            // Close database connection
            mysqli_close($conn);
            ?>
        </select>
        <label for="team1">Team 1:</label>
        <input type="text" id="team1" name="team1" class="form-control mb-2" required>
        <label for="team2">Team 2:</label>
        <input type="text" id="team2" name="team2" class="form-control mb-2" required>
        <label for="odds_team1">Odds for Team 1:</label>
        <input type="text" id="odds_team1" name="odds_team1" class="form-control mb-2" required>
        <label for="odds_team2">Odds for Team 2:</label>
        <input type="text" id="odds_team2" name="odds_team2" class="form-control mb-2" required>
        <label for="win_team">Winning Team:</label>
        <input type="text" id="win_team" name="win_team" class="form-control mb-2" required>
        <label for="date_played">Date Played:</label>
        <input type="date" id="date_played" name="date_played" class="form-control mb-2" required>
        <input type="submit" value="Add Match" class="btn btn-primary">
    </form>
</div>

<?php include './layout/footer.php'; ?>
