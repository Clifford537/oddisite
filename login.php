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
<style>
    .login-form {
        max-width: 350px;
        margin: 20px auto;
        padding: 15px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
    }

    .login-heading {
        font-size: 20px;
        color: #333;
        text-align: center;
        margin-bottom: 15px;
    }

    .login-label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #030303;
        font-size: 14px;
    }

    .login-select,
    .login-input {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-sizing: border-box;
        font-size: 14px;
    }

    .login-button {
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

    .login-button:hover {
        background-color: #45a049;
    }
</style>
<body>
    <h2 class="login-heading"></h2>
    <form action="login_process.php" method="post" class="login-form">
        <p class="text-dark login-heading">LOGIN</p>
        
        <label for="usertype" class="login-label">User Type:</label>
        <select id="usertype" name="usertype" required class="login-select">
            <?php foreach ($usertypes as $usertype): ?>
                <option value="<?= htmlspecialchars($usertype) ?>" class="login-option"><?= htmlspecialchars($usertype) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="password" class="login-label">Password:</label>
        <input type="password" id="password" name="password" required class="login-input">

        <label for="unique_code" class="login-label">Unique Code:</label>
        <input type="text" id="unique_code" name="unique_code" required class="login-input">

        <input type="submit" value="Login" class="login-button">
    </form>
</body>

<?php include './layout/footer.php'; ?>
