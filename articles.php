<?php include './layout/header.php'; ?>
<style>
    .article {
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    background-color: #f9f9f9;
}

.article-content {
    margin-left: 20px; /* Adjust as needed for spacing */
}

.article-heading {
    font-size: 1.5rem; /* Adjust heading size */
}

.article-image {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
}

.fa-user {
    font-size: 0.8rem; /* Adjust icon size */
    margin-right: 5px; /* Adjust spacing */
}

</style>
<?php
// Include your database connection file
include 'dbconnection.php';

// Query to fetch latest articles
$sql = "SELECT article_id, title, content, author, published_date, category, image_url
        FROM articles
        ORDER BY published_date DESC
        LIMIT 10"; // Adjust limit as needed

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $article_id = $row['article_id'];
        $title = $row['title'];
        $content = $row['content'];
        $author = $row['author'];
        $published_date = $row['published_date'];
        $category = $row['category'];
        $image_url = $row['image_url'];

        // Display each article
        echo '<div class="article">';
        echo '<div class="article-content">';
        echo '<h2 class="article-heading" style="color: green;">' . htmlspecialchars($title) . '</h2>';
        echo '<img src="' . htmlspecialchars($image_url) . '" alt="' . htmlspecialchars($title) . '" class="article-image">';
        echo '<p><i class="fa fa-user" style="color: blue;"></i> ' . htmlspecialchars($author) . '</p>';
        echo '<p style="color: orange; font-size: 0.8rem;">' . htmlspecialchars($category) . '</p>';
        echo '<p style="color: dark;">' . nl2br(htmlspecialchars($content)) . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>No articles found.</p>';
}

// Close the database connection
$conn->close();
?>
<?php include './layout/footer.php'; ?>