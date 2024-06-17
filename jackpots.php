<?php include './layout/header.php'; ?>

<div class="container">
    <?php
    // Include database connection
    include 'dbconnection.php';

    // Query to fetch jackpot types
    $query_types = "SELECT id, type FROM jackpottypes";
    $result_types = $conn->query($query_types);

    // Iterate through each jackpot type
    while ($type_row = $result_types->fetch_assoc()) {
        $jackpottype_id = $type_row['id'];
        $jackpottype_name = $type_row['type'];

        // Fetch jackpots data for current jackpot type
        $sql = "SELECT team1, team2, win, date_played FROM jackpots WHERE jackpottype_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $jackpottype_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Initialize counter for matches
        $match_count = 0;

        if ($result->num_rows > 0) {
            // Display jackpot type section
            echo '<div id="jackpottype' . $jackpottype_id . '" class="jackpottype card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title text-center">' . $jackpottype_name . '</h5>';
            echo '<table class="table table-bordered">';
            echo '<thead><tr><th>Team 1</th><th>Team 2</th><th>Win</th><th>Date Played</th></tr></thead>';
            echo '<tbody>';

            // Display jackpots data with maximum of 17 matches
            while ($row = $result->fetch_assoc()) {
                if ($match_count >= 17) {
                    break; // Break out of the loop if maximum matches reached
                }
                
                echo '<tr>';
                echo '<td>' . $row['team1'] . '</td>';
                echo '<td>' . $row['team2'] . '</td>';
                echo '<td>' . $row['win'] . '</td>';
                echo '<td>' . $row['date_played'] . '</td>';
                echo '</tr>';
                
                $match_count++;
            }

            echo '</tbody></table></div></div>';
        } else {
            // No jackpots found for this type
            echo '<div id="jackpottype' . $jackpottype_id . '" class="jackpottype card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title text-center">' . $jackpottype_name . '</h5>';
            echo '<p>No jackpots found for this type.</p>';
            echo '</div></div>';
        }

        $stmt->close();
    }

    // Close database connection
    $conn->close();
    ?>
</div>

<?php include './layout/footer.php'; ?>
