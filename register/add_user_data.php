
<?php

session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {

    header("Location: ../login.php");
    exit();
}


$isSuperadmin = ($_SESSION['usertype'] === 'SU');
$isAdmin = ($_SESSION['usertype'] === 'Admin');
$isUser = ($_SESSION['usertype'] === 'User');


$pageTitle = "Dashboard";
?>

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
    <?php include '../layout/header.php'; ?>
    <style>
        .form-container {
            max-width: 350px;
            margin: 20px auto;
            padding: 15px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        .form-heading {
            font-size: 20px;
            color: #333;
            text-align: center;
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #030303;
            font-size: 14px;
        }

        .form-select,
        .form-input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form-button {
            width: 50%;
            padding: 10px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
            display: block;
            margin: 0 auto;
        }

        .form-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="form-heading">Add User Data</h2>
        <form action="add_user.php" method="post">
            <label for="usertype" class="form-label">User Type:</label>
            <select id="usertype" name="usertype" required class="form-select">
                <?php foreach ($usertypes as $usertype): ?>
                    <option value="<?= htmlspecialchars($usertype) ?>"><?= htmlspecialchars($usertype) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="username" class="form-label">Username:</label>
            <input type="text" id="username" name="username" required class="form-input">

            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" required class="form-input">

            <input type="submit" value="Add User" class="form-button">
        </form>
    </div>
    <?php include '../layout/footer.php'; ?>
</body>
</html>
