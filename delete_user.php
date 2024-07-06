<?php
// Include header

session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    header("Location: login.php");
    exit();
}

$isSuperadmin = ($_SESSION['usertype'] === 'SU');
$isAdmin = ($_SESSION['usertype'] === 'Admin');
$isUser = ($_SESSION['usertype'] === 'User');
include './layout/header.php';

// Include database connection
include 'dbconnection.php';

// Check if user ID is provided and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare SQL statement to delete user
    $sql_delete = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $user_id);

    // Execute the delete statement
    if ($stmt->execute()) {
        echo '<script>alert("User deleted successfully.");</script>';
    } else {
        echo '<script>alert("Error deleting user.");</script>';
    }

    // Close statement
    $stmt->close();
}

// Fetch all users from the database
$sql_users = "SELECT id, username, unique_code, date_created FROM users";
$result = $conn->query($sql_users);

// Check if users exist
if ($result->num_rows > 0) {
    echo "<h2>Available Users</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Username</th><th>Unique Code</th><th>Date Created</th><th>Action</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['id'];
        $username = htmlspecialchars($row['username']);
        $unique_code = htmlspecialchars($row['unique_code']);
        $date_created = htmlspecialchars($row['date_created']);

        echo "<tr>";
        echo "<td>{$user_id}</td>";
        echo "<td>{$username}</td>";
        echo "<td>{$unique_code}</td>";
        echo "<td>{$date_created}</td>";
        echo "<td><a href='delete_user.php?id={$user_id}' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No users found.";
}

// Include footer or close HTML structure
include './layout/footer.php';
?>
