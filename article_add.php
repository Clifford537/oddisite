<?php
// Start session (if not already started)
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page or display an error message
    header('Location: login.php'); // Replace with your login page URL
    exit;
}

// Continue with your existing code
include 'dbconnection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $published_date = $_POST['published_date'];
    $category = $_POST['category'];

    // File upload handling (your existing code for file upload)

    // If everything is ok, try to upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file; // Store image path in database

            // SQL query to insert the article into the database (your existing SQL query)

            if ($conn->query($sql) === TRUE) {
                echo "Article added successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Close the database connection
    $conn->close();
}
?>
