<?php include './layout/header.php'; ?>

<div class="container mt-5">
    <style>
        .card {
            border: none;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-title {
            color: #333;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center; /* Center align the title */
        }
        
        .card-text {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .card-img-top {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            display: block;
            margin: 0 auto; /* Center align the image */
            max-height: 300px; /* Limit image height */
            object-fit: cover; /* Ensure image covers entire container */
        }
    </style>

    <?php
    // Include database connection
    include 'dbconnection.php';

    // Validate and sanitize article_id
    $article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Fetch article details
    $sql_article = "SELECT title, content, author, published_date, category, image_url 
                    FROM articles 
                    WHERE article_id = $article_id";
    $result_article = $conn->query($sql_article);

    if ($result_article && $result_article->num_rows > 0) {
        $article = $result_article->fetch_assoc();
        $title = htmlspecialchars($article['title']);
        $content = htmlspecialchars($article['content']);
        $author = htmlspecialchars($article['author']);
        $published_date = htmlspecialchars($article['published_date']);
        $category = htmlspecialchars($article['category']);
        $image_url = htmlspecialchars($article['image_url']);

        // Display article content
        echo '<div class="card shadow-sm">';
        echo '<div class="card-body">';
        echo '<h1 class="card-title">' . $title . '</h1>';
        
        // Display image if available
        if (!empty($image_url)) {
            echo '<img src="' . $image_url . '" class="card-img-top article-image img-fluid mb-3" alt="' . $title . '">';
        }
        
        echo '<p class="card-text text-muted mb-2"><strong>Category:</strong> ' . $category . '</p>';
        echo '<p class="card-text">' . nl2br($content) . '</p>'; // Display full content with line breaks preserved
        echo '<p class="card-text"><small class="text-muted"><i class="fa fa-user"></i> ' . $author . '</small></p>';
        echo '<p class="card-text"><small class="text-muted"><i class="fa fa-calendar"></i> Published on ' . date("M d, Y", strtotime($published_date)) . '</small></p>';
        echo '</div>'; // Close card-body
        echo '</div>'; // Close card
    } else {
        echo "<p class='col-md-12'>Article not found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
</div> <!-- .container -->

<?php include './layout/footer.php'; ?>
