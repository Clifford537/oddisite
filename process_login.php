<?php
// Include database connection
include 'dbconnection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Initialize session
session_start();

// Check if the form was submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            $_SESSION['error'] = "Invalid password";
        }
    } else {
        // User not found
        $_SESSION['error'] = "User not found";
    }

    $stmt->close();
} else {
    // Redirect to login page if accessed directly without POST method
    $_SESSION['error'] = "Access denied";
}

// Redirect back to login page with error message
header("Location: login.php?error=" . urlencode($_SESSION['error']));
exit();

$conn->close();
?>
