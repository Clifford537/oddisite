<?php

session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {

    header("Location: login.php");
    exit();
}


$isSuperadmin = ($_SESSION['usertype'] === 'Superadmin');
$isAdmin = ($_SESSION['usertype'] === 'Admin');
$isUser = ($_SESSION['usertype'] === 'User');


$pageTitle = "Dashboard";
?>

<?php include './layout/header.php'; ?>

<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

<?php if ($isSuperadmin || $isAdmin): ?>
    <div class="button-container">
        <button onclick="location.href='match_add_form.php'" class="dashboard-button">Add Match</button>
        <button onclick="location.href='delete_match.php'" class="dashboard-button">Delete Match</button>
        <button onclick="location.href='edit_match.php'" class="dashboard-button">Edit Match</button>
    </div>
<?php endif; ?>

<?php if ($isSuperadmin): ?>
    <div class="button-container">
        <button onclick="location.href='delete_users.php'" class="dashboard-button">Delete Users</button>
        <button onclick="location.href='add_user.php'" class="dashboard-button">Add User</button>
    </div>
<?php endif; ?>

<div class="button-container">
    <button onclick="location.href='logout.php'" class="dashboard-button">Logout</button>
</div>

<?php include './layout/footer.php'; ?>
