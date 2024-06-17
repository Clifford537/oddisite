<?php include './layout/header.php'; ?>

<h2 class="form-heading">Add Match</h2>
<div class="container">
    <style>
        .register-form {
            max-width: 430px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-height: fit-content;
        }

        .register-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .register-form input[type="text"],
        .register-form input[type="date"],
        .register-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .register-form input[type="submit"] {
            width: 50%;
            padding: 12px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            display: block;
            margin: 0 auto;
        }

        .register-form input[type="submit"]:hover {
            background-color: #218838;
        }

        .form-heading {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
    <form action="match_add.php" method="POST" class="register-form">
        <label for="plan_id">Select Plan:</label>
        <select id="plan_id" name="plan_id" required>
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
        <input type="text" id="team1" name="team1" required>
        <label for="team2">Team 2:</label>
        <input type="text" id="team2" name="team2" required>
        <label for="odds_team1">Odds for Team 1:</label>
        <input type="text" id="odds_team1" name="odds_team1" required>
        <label for="odds_team2">Odds for Team 2:</label>
        <input type="text" id="odds_team2" name="odds_team2" required>
        <label for="win_team">Winning Team:</label>
        <input type="text" id="win_team" name="win_team" required>
        <label for="date_played">Date Played:</label>
        <input type="date" id="date_played" name="date_played" required>
        <input type="submit" value="Add Match">
    </form>
</div>

<?php include './layout/footer.php'; ?>
