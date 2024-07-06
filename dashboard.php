<?php

session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {

    header("Location: login.php");
    exit();
}


$isSuperadmin = ($_SESSION['usertype'] === 'SU');
$isAdmin = ($_SESSION['usertype'] === 'Admin');
$isUser = ($_SESSION['usertype'] === 'User');


$pageTitle = "Dashboard";
?>

<?php include './layout/header.php'; ?>

<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

<?php if ($isSuperadmin || $isAdmin): ?>
    <div class="button-container">
        <button onclick="location.href='match_add_form'" class="dashboard-button">Add League</button>
        <button onclick="location.href='./jackpot/add_jackpot_form'" class="dashboard-button">Add Jackpots</button>
        <button onclick="location.href='article_add_form'" class="dashboard-button">add article</button>
        <button onclick="location.href='./views/view_plans'" class="dashboard-button">View Plans</button>
        <button onclick="location.href='./views/view_jackpot'" class="dashboard-button">View Jackpot</button>
    </div>
<?php endif; ?>

<?php if ($isSuperadmin): ?>
    <div class="button-container">
        <button onclick="location.href='delete_user.php'" class="dashboard-button">Delete Users</button>
        <button onclick="location.href='./register/add_user_data.php'" class="dashboard-button">Add User</button>
    </div>
<?php endif; ?>

<div class="button-container">
    <button onclick="location.href='logout.php'" class="dashboard-button">Logout</button>
</div>

<?php include './layout/footer.php'; ?>
