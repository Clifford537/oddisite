
<?php
// Include the database connection
include '../dbconnection.php';

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

<!DOCTYPE html>
<html>
<head>
    <title>Add User Data</title>
</head>
<body>
    <h2>Add User Data</h2>
    <form action="add_user.php" method="post">
        <label for="usertype">User Type:</label><br>
        <select id="usertype" name="usertype" required>
            <?php foreach ($usertypes as $usertype): ?>
                <option value="<?= htmlspecialchars($usertype) ?>"><?= htmlspecialchars($usertype) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Add User">
    </form>
</body>
</html>
