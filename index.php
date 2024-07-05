<?php include './layout/header.php'; ?>
    <style>
        .container {
            display: flex;
        }
        .column {
            width: 50%;
            padding: 10px;
        }
        /* Styles for league tables */
        .leaguetable {
            margin-bottom: 20px;
            border: 1px solid #ced4da; /* Bootstrap default border color */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Soft shadow */
            background-color: #ffffff; /* White background */
            padding: 20px;
        }

        /* Styles for league table headers */
        .leaguetable thead {
            background-color: #28a745; /* Green background */
        }

        .leaguetable th {
            color: #ffffff; /* White text */
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            background-color: ##28a745;
        }
        .leaguetable thead {
    background-color: #28a745; /* Green background */
}

        /* Styles for league table cells */
        .leaguetable td {
            text-align: center;
            vertical-align: middle;
        }

        /* Optional: Hover effect for table rows */
        .leaguetable tbody tr:hover {
            background-color: #f8f9fa; /* Bootstrap light gray hover */
        }

        /* Styles for green text */
        .green-text {
            color: #28a745; /* Green color */
            font-weight: bold; /* Bold font */
        }

        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .card h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
            text-align: center;
        }
        .card p {
            margin: 5px 0;
        }
        h1, h3 {
            text-align: center;
            font-weight:bolder;
        }
        .jackpot-link, .article-link {
            text-decoration: none;
            color: blue;
        }
        .article {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            color: #28a745;
        }
        .article h2 {
            text-align: center;
            font-weight:bold;
            font-size: 22px;
        }
        .article p {
            font-size: 16px;
            color: salmon;
            text-align: justify;
            font-weight:bold;
        }
        .article-content {
            margin-bottom: 10px;
        }
        .article img {
            max-width: 100%;
            margin-bottom: 10px;
            width: 100%;
            height: 100%;
        }
.card.site-description {
    background-color: #f0f0f0;
    color: #444;
    padding: 20px;
    margin-top: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.card-body {
    padding: 20px;
}

.column h5 {
    font-size: 1rem;
    color: #007bff; /* Blue color for section headings */
}

ul {
    list-style-type: none;
    padding-left: 0;
}

ul li {
    margin-bottom: 5px;
}

ul.social-media-list li a,
ul.policy-list li a {
    color: #007bff; /* Blue color for links */
}

ul.social-media-list li a:hover,
ul.policy-list li a:hover {
    text-decoration: none;
    color: #0056b3; /* Darker blue for hovered links */
}

.policy-list strong {
    font-weight: bold;
}

.row-footer {
    margin-top: 20px;
}

.row-footer p {
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 5px;
}

.row-footer p a {
    color: #007bff; /* Blue color for footer links */
}

.row-footer p a:hover {
    text-decoration: none;
    color: #0056b3; /* Darker blue for hovered footer links */
}
.container {
    display: flex;
    flex-wrap: wrap; /* Allows wrapping of columns */
}

.column {
    width: 50%;
    padding: 10px;
    box-sizing: border-box;
}

/* Responsive styles for smaller screens */
@media (max-width: 768px) {
    .column {
        width: 100%; /* Full width for columns on smaller screens */
    }
}
    </style>
<body>
    
<div class="card site-description bg-light">
    <div class="card-body">
        <h4 class="card-title text-center text-success">Free betting odds and Tips </h4>
        <div class="d-flex justify-content-center align-items-center mt-3">
            <p class="card-text text-center mb-0">Sports betting tips and sure betting odds predictions, catering to all sports enthusiasts worldwide.</p>
            <img src="./uploads/download.gif" alt="Betting responsibly" class="rounded-circle ml-2" style="width: 50px; height: 50px;">
        </div>
    </div>
</div>

<div class="container">
<div class="column col-md-6">
    <?php
    include 'dbconnection.php';

    // Fetch match types
    $sql = "SELECT type FROM matchtype";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $type = $row['type'];
            $league_name = "<span class='green-text'>$type</span> <span class='green-text'>Predictions</span>"; // Green color applied here

            // Fetch matches for the current match type
            $sql_matches = "SELECT match_date, team_1, team_2, winteam, team_1_odds, team_2_odds 
                            FROM matches 
                            WHERE type='$type'";
            $result_matches = $conn->query($sql_matches);

            if ($result_matches->num_rows > 0) {
                echo "<div class='card'>";
                echo "<h3>$league_name</h3>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered leaguetable'>";
                echo "<thead class='thead'>
                        <tr>
                            <th>Date</th>
                            <th>Match</th>
                            <th>Winning Team</th>
                            <th>Winning Odds</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                $total_winning_odds = 0;
                while ($match = $result_matches->fetch_assoc()) {
                    $match_date = $match['match_date'];
                    $team_1 = $match['team_1'];
                    $team_2 = $match['team_2'];
                    $winteam = $match['winteam'];
                    $team_1_odds = $match['team_1_odds'];
                    $team_2_odds = $match['team_2_odds'];
                    $winning_odds = $winteam == $team_1 ? $team_1_odds : $team_2_odds;
                    $total_winning_odds += $winning_odds;

                    echo "<tr>
                            <td>$match_date</td>
                            <td>$team_1 vs $team_2</td>
                            <td>$winteam</td>
                            <td>$winning_odds</td>
                          </tr>";
                }
                echo "<tr>
                        <td colspan='3'><strong>Total Winning Odds</strong></td>
                        <td><strong>$total_winning_odds</strong></td>
                      </tr>";
                echo "</tbody>";
                echo "</table>";
                echo "</div>"; // Close table-responsive
                echo "</div>"; // Close card
            }
        }
    } else {
        echo "<p>No match types available.</p>";
    }

    $conn->close();
    ?>
</div>

    <div class="column col-md-6">
        <div class="card">
            <h3>View Jackpots Predictions</h3>
            <p><a href="jackpots.php?id=1" class="jackpot-link">Odibet</a> - Jackpot predictions for Odibet.</p>
            <p><a href="jackpots.php?id=2" class="jackpot-link">Sportpesa</a> - Jackpot predictions for Sportpesa.</p>
            <p><a href="jackpots.php?id=3" class="jackpot-link">Betpower</a> - Jackpot predictions for Betpower.</p>
            <p><a href="jackpots.php?id=4" class="jackpot-link">Mazzartbet</a> - Jackpot predictions for Mazzartbet.</p>
        </div>

        <div class="card">
            <h3>Read our Articles</h3>
            <?php
            include 'dbconnection.php';

            // Fetch latest articles
            $sql_articles = "SELECT article_id, title, content, author, published_date, category, image_url 
                             FROM articles 
                             ORDER BY published_date DESC 
                             LIMIT 3";

            $result_articles = $conn->query($sql_articles);

            if ($result_articles) {
                if ($result_articles->num_rows > 0) {
                    while ($article = $result_articles->fetch_assoc()) {
                        // Process each article
                        $article_id = $article['article_id'];
                        $title = htmlspecialchars($article['title']);
                        $content = htmlspecialchars($article['content']);
                        $author = htmlspecialchars($article['author']);
                        $published_date = htmlspecialchars($article['published_date']);
                        $category = htmlspecialchars($article['category']);
                        $image_url = htmlspecialchars($article['image_url']);

                        // Output article information in a professional format
                        echo '<div class="article">';
                        echo '<h2>' . $title . '</h2>';
                        echo '<p class=" text-info">Category: ' . $category . '</p>';
                        echo '<div class="article-content">';
                        // Display a part of the content
                        echo '<p>' . substr($content, 0, 200) . '...</p>'; // Display first 200 characters of content
                        echo '</div>';
                        if (!empty($image_url)) {
                            echo '<img src="' . $image_url . '" alt="' . $title . '" class="article-image">';
                        }
                        echo '<p class=" text-dark"><i class="fa fa-user text-success"></i> ' . $author . '</p>'; // User icon and author name
                        echo '</div>'; // Close article div
                    }
                } else {
                    echo "<p>No articles available.</p>";
                }
            } else {
                echo "Error: " . $conn->error;
            }

            // Close the database connection
            $conn->close();
            ?>
            <p><a href="articles.php" class="article-link">View All Articles</a></p>
        </div>
    </div>
</div>

<?php include './layout/footer.php'; ?>
