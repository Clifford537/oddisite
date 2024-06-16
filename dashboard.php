<?php
// Start session to access session variables
session_start();

// Check if user is logged in and their usertype
if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if user is Superadmin, Admin, or User
$isSuperadmin = ($_SESSION['usertype'] === 'Superadmin');
$isAdmin = ($_SESSION['usertype'] === 'Admin');
$isUser = ($_SESSION['usertype'] === 'User');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        .button-container {
            margin-top: 20px;
        }
        .button-container button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

    <?php if ($isSuperadmin || $isAdmin): ?>
        <div class="button-container">
            <button onclick="location.href='add_match.php'">Add Match</button>
            <button onclick="location.href='delete_match.php'">Delete Match</button>
            <button onclick="location.href='edit_match.php'">Edit Match</button>
        </div>
    <?php endif; ?>

    <?php if ($isSuperadmin): ?>
        <div class="button-container">
            <button onclick="location.href='delete_users.php'">Delete Users</button>
            <button onclick="location.href='add_user.php'">Add User</button>
        </div>
    <?php endif; ?>
    
    <div class="button-container">
        <button onclick="location.href='logout.php'">Logout</button>
    </div>
</body>
</html>
