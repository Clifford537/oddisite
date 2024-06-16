<?php
// Include database connection
include 'dbconnection.php';

// Initialize session
session_start();

// Retrieve form data
$usertype = $_POST['usertype'];
$password = $_POST['password'];
$unique_code = $_POST['unique_code'];

// SQL query to retrieve user based on usertype and unique_code
$sql = "SELECT * FROM users WHERE usertype = ? AND unique_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usertype, $unique_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    // Verify hashed password
    if (password_verify($password, $user['password_hash'])) {
        // Password is correct, set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['usertype'] = $user['usertype'];
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid password
        echo "Invalid password. <a href='dashboard.php'>Try again</a>";
    }
} else {
    // User not found
    echo "User not found. <a href='login.php'>Try again</a>";
}

$stmt->close();
$conn->close();
?>
