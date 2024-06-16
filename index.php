<?php include './layout/header.php'; ?>

<div class="container">
    <?php
    // Include database connection
    include 'dbconnection.php';

    // Query to fetch matches for each plan
    $plans = array(
        array('id' => 1, 'name' => 'PLAN 1 (3 MATCHES)'),
        array('id' => 2, 'name' => 'PLAN 2 (6 MATCHES)'),
        array('id' => 3, 'name' => 'PLAN 3 (10 MATCHES)')
    );

    foreach ($plans as $plan) {
        $plan_id = $plan['id'];

        // Fetch matches data for current plan
        $sql = "SELECT team1, team2, win_team, odds_team1, odds_team2 FROM matches WHERE plan_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $plan_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Display plan section
            echo '<div id="plan' . $plan_id . '" class="plan card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title text-center">' . $plan['name'] . '</h5>';
            echo '<table class="table table-bordered">';
            echo '<thead><tr><th>Matches</th><th>Choices</th><th>Total Odds</th></tr></thead>';
            echo '<tbody>';

            // Display matches data
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['team1'] . ' vs ' . $row['team2'] . '</td>';
                echo '<td>' . ($row['win_team'] ? $row['win_team'] . ' to win' : 'No winner yet') . '</td>';
                echo '<td class="text-success">' . $row['odds_team1'] . '</td>';
                echo '</tr>';
            }

            echo '</tbody></table></div></div>';
        } else {
            // No matches found for this plan
            echo '<div id="plan' . $plan_id . '" class="plan card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title text-center">' . $plan['name'] . '</h5>';
            echo '<p>No matches found for this plan.</p>';
            echo '</div></div>';
        }

        $stmt->close();
    }

    // Close database connection
    $conn->close();
    ?>
</div>

<?php include './layout/footer.php'; ?>
