<?php
// Initialize session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if usertype is Admin or Superadmin
if ($_SESSION['usertype'] !== 'Admin' && $_SESSION['usertype'] !== 'Superadmin') {
    // Redirect to login page with error message if not authorized
    $_SESSION['error'] = "Access denied. You do not have permission to access this page.";
    header("Location: login.php");
    exit();
}

// Display dashboard content based on usertype
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome <?php echo $_SESSION['usertype'] . ": " . $_SESSION['username']; ?></h2>
    
    <!-- Dashboard buttons based on usertype -->
    <?php if ($_SESSION['usertype'] === 'Admin' || $_SESSION['usertype'] === 'Superadmin'): ?>
        <button onclick="location.href='match_add_form.php'">Add Match</button>
    <?php endif; ?>
    
    <!-- Additional buttons or content based on usertype -->
    
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
