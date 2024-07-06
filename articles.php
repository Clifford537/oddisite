<?php include './layout/header.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4">Latest Articles</h1>
    <div class="row">
        <?php
        // Include database connection
        include 'dbconnection.php';

        // Fetch articles
        $sql_articles = "SELECT article_id, title, content, author, published_date, category, image_url 
                        FROM articles 
                        ORDER BY published_date DESC"; // Fetch all articles, ordered by published date

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

                    
                    echo '<div class="col-md-6 mb-4">';
                    echo '<div class="card shadow-sm">';
                    if (!empty($image_url)) {
                        echo '<img src="' . $image_url . '" class="card-img-top article-image" alt="' . $title . '">';
                    }
                    echo '<div class="card-body">';
                    echo '<h2 class="card-title">' . $title . '</h2>';
                    echo '<p class="card-text text-muted mb-2">Category: ' . $category . '</p>';
                    echo '<p class="card-text">' . substr($content, 0, 200) . '...</p>'; // Display first 200 characters of content
                    echo '<p class="card-text"><small class="text-muted"><i class="fa fa-user"></i> ' . $author . '</small></p>';
                    echo '<a href="article_content.php?id=' . $article_id . '" class="btn btn-primary">Read More</a>'; // Link to full article
                    echo '</div>'; // Close card-body
                    echo '<div class="card-footer">';
                    echo '<small class="text-muted">Published on ' . date("M d, Y", strtotime($published_date)) . '</small>';
                    echo '</div>'; // Close card-footer
                    echo '</div>'; // Close card
                    echo '</div>'; // Close column
                }
            } else {
                echo "<p class='col-md-12'>No articles available.</p>";
            }
        } else {
            echo "<p class='col-md-12'>Error: " . $conn->error . "</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div> <!-- .row -->
</div> <!-- .container -->

<?php include './layout/footer.php'; ?>
