<?php include './layout/header.php'; ?>

<div class="containerjackpot">
    <div class="row">
        <?php
        // Include database connection
        include 'dbconnection.php';

        // Query to fetch jackpot types
        $query_types = "SELECT id, type FROM jackpottypes";
        $result_types = $conn->query($query_types);

        // Initialize counter for columns
        $col_count = 0;

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

            if ($result->num_rows > 0) {
                // Initialize counter for matches
                $match_count = 0;

                // Start a new row if this is the first item or if we have displayed 2 items already
                if ($col_count % 2 == 0 && $col_count > 0) {
                    echo '</div><div class="row">';
                }

                echo '<div class="col-md-6">';
                // Display jackpot type section
                echo '<div id="jackpottype' . $jackpottype_id . '" class="jackpottype card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title text-center">' . $jackpottype_name . '</h5>';
                echo '<table class="table table-bordered">';
                echo '<thead><tr><th>Date Played</th><th>Game</th><th>Win</th></tr></thead>';
                echo '<tbody>';

                // Display jackpots data with maximum of 17 matches
                while ($row = $result->fetch_assoc()) {
                    if ($match_count >= 17) {
                        break; // Break out of the loop if maximum matches reached
                    }

                    echo '<tr>';
                    echo '<td>' . $row['date_played'] . '</td>';
                    echo '<td>' . $row['team1'] . ' vs ' . $row['team2'] . '</td>';
                    echo '<td>' . $row['win'] . '</td>';
                    echo '</tr>';

                    $match_count++;
                }

                echo '</tbody></table></div></div>';
                echo '</div>';

                $col_count++;
            }

            $stmt->close();
        }

        // Close database connection
        $conn->close();
        ?>
    </div>
</div>

<?php include './layout/footer.php'; ?>
