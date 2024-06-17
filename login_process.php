<?php
// Start the session
session_start();

// Include the database connection
include 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $usertype = $_POST['usertype'];
    $password = $_POST['password'];
    $unique_code = $_POST['unique_code'];

    // Prepare and execute query to check credentials
    $stmt = $conn->prepare("SELECT u.id, u.username, u.password, ut.usertype 
                            FROM users u
                            INNER JOIN usertypes ut ON u.usertype_id = ut.id
                            WHERE ut.usertype = ? AND u.unique_code = ?");
    $stmt->bind_param("ss", $usertype, $unique_code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $hashed_password, $usertype_name);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Store user information in session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $usertype_name; // Store usertype name instead of id

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "Invalid usertype or unique code";
    }

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>
