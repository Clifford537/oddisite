<?php include './layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php
            // Include database connection
            include 'dbconnection.php';

            // Define plans with their respective maximum match counts
            $plans = array(
                array('id' => 1, 'name' => 'tips 1', 'max_matches' => 50),
                array('id' => 2, 'name' => 'tips 2', 'max_matches' => 50),
                array('id' => 3, 'name' => 'tips 3', 'max_matches' => 50)
            );

            // Iterate through each plan
            foreach ($plans as $plan) {
                $plan_id = $plan['id'];
                $max_matches = $plan['max_matches'];

                // Fetch matches data for current plan including date_played
                $sql = "SELECT team1, team2, win_team, odds_team1, odds_team2, date_played 
                        FROM matches 
                        WHERE plan_id = ?
                        ORDER BY date_played DESC
                        LIMIT ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $plan_id, $max_matches);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Display plan section
                    echo '<div id="plan' . $plan_id . '" class="plan card mb-3">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title text-center">' . $plan['name'] . '</h5>';
                    echo '<div style="max-height: 500px; overflow-y: auto;">'; // Scrollable div for matches table
                    echo '<table class="table table-bordered">';
                    echo '<thead><tr><th>Matches</th><th>Win Team</th><th>Win Team Odds</th><th>Date Played</th></tr></thead>';
                    echo '<tbody>';

                    // Initialize variables for total odds and match count
                    $total_odds = 1;
                    $match_count = 0;

                    // Display matches data
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['team1'] . ' vs ' . $row['team2'] . '</td>';
                        echo '<td>' . ($row['win_team'] ? $row['win_team'] : 'No winner yet') . '</td>';

                        // Determine the odds of the winning team
                        $win_team_odds = ($row['win_team'] == $row['team1']) ? $row['odds_team1'] : $row['odds_team2'];
                        echo '<td class="text-success">' . $win_team_odds . '</td>';

                        echo '<td>' . ($row['date_played'] ? $row['date_played'] : 'Not played yet') . '</td>'; // Display date_played or indicate not played yet
                        echo '</tr>';

                        // Calculate total odds for the winning teams
                        if ($row['win_team']) {
                            $total_odds *= $win_team_odds;
                            $match_count++;
                        }
                    }

                    // Display total odds and close table
                    if ($match_count > 0) {
                        echo '<tr>';
                        echo '<td colspan="2"><strong>Total Odds:</strong></td>';
                        echo '<td colspan="2"><strong>' . number_format($total_odds, 2) . '</strong></td>';
                        echo '</tr>';
                    }

                    echo '</tbody></table>';
                    echo '</div>'; // Close scrollable div
                    echo '</div></div>';
                } else {
                    // No matches found for this plan
                    echo '<div id="plan' . $plan_id . '" class="plan card mb-3">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title text-center">' . $plan['name'] . '</h5>';
                    echo '<p class="text-center">No matches found for this plan.</p>';
                    echo '</div></div>';
                }

                $stmt->close();
            }

            // Close database connection
            $conn->close();
            ?>
        </div>
    </div>
</div>

<?php include './layout/footer.php'; ?>
