<?php
session_start();

// Include the database connection
include 'dbconnection.php';

// Helper function to get device name
function get_device_name($user_agent) {
    if (preg_match('/mobile/i', $user_agent)) {
        return 'Mobile';
    } else if (preg_match('/tablet/i', $user_agent)) {
        return 'Tablet';
    } else {
        return 'Desktop';
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $published_date = $_POST['published_date'];
    $category = $_POST['category'];

    // File upload handling
    $target_dir = "uploads/"; // Directory where uploaded images will be stored
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (adjust as needed)
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats (adjust as needed)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file; // Store image path in database

            // SQL query to insert the article into the database
            $sql = "INSERT INTO articles (title, content, author, published_date, category, image_url)
                    VALUES ('$title', '$content', '$author', '$published_date', '$category', '$image_url')";

            if ($conn->query($sql) === TRUE) {
                echo "Article added successfully!";

                // Log the user action
                $user_id = $_SESSION['user_id'];
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $device_name = gethostbyaddr($ip_address);
                $device_type = get_device_name($_SERVER['HTTP_USER_AGENT']);
                
                $sql_log = "INSERT INTO user_actions (user_id, action, ip_address, device_name, device_type, timestamp)
                            VALUES (?, ?, ?, ?, ?, NOW())";
                $stmt_log = $conn->prepare($sql_log);
                $action = 'Add Article';
                $stmt_log->bind_param('issss', $user_id, $action, $ip_address, $device_name, $device_type);
                $stmt_log->execute();
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
