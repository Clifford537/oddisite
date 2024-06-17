<?php
// Include the database connection
include 'dbconnection.php';

// Fetch distinct user types from the database
$query = "SELECT DISTINCT usertype FROM usertypes";
$result = $conn->query($query);

$usertypes = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usertypes[] = $row['usertype'];
    }
}

$conn->close();
?>
<?php include './layout/header.php'; ?>
<body>
  <h2 class="login-heading"></h2>
    <form action="login_process.php" method="post" class="login-form">
        <p class="text-dark login-heading">LOGIN</p>
        <label for="usertype" class="login-label">User Type:</label><br>
        <select id="usertype" name="usertype" required class="login-select">
            <?php foreach ($usertypes as $usertype): ?>
                <option value="<?= htmlspecialchars($usertype) ?>" class="login-option"><?= htmlspecialchars($usertype) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="password" class="login-label">Password:</label><br>
        <input type="password" id="password" name="password" required class="login-input"><br><br>

        <label for="unique_code" class="login-label">Unique Code:</label><br>
        <input type="text" id="unique_code" name="unique_code" required class="login-input"><br><br>

        <input type="submit" value="Login" class="login-button">
    </form>
</body>

<?php include './layout/footer.php'; ?>
