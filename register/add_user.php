<?php
// Start session (if not already started)
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    // Redirect to login page if not logged in
    header("Location: ../login.php");
    exit();
}

// Continue with your existing code
include '../dbconnection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'usertype' exists in the POST data and set a default value if not
    if (isset($_POST['usertype']) && !empty($_POST['usertype'])) {
        $usertype = $_POST['usertype'];
    } else {
        echo "Usertype is missing.";
        exit;
    }

    // Get form data
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Fetch the usertype_id from the database based on the usertype
    $stmt = $conn->prepare("SELECT id FROM usertypes WHERE usertype = ?");
    $stmt->bind_param("s", $usertype);
    $stmt->execute();
    $stmt->bind_result($usertype_id);
    $stmt->fetch();
    $stmt->close();

    if (!$usertype_id) {
        echo "Invalid usertype.";
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (usertype_id, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $usertype_id, $username, $password);

    // Execute the statement
    try {
        $stmt->execute();
        echo "New record created successfully";
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
