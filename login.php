<?php
// Include header
$pageTitle = "Login"; // Set the page title dynamically
include './layout/header.php';
?>

<h2>Login</h2>

<?php
// Check if there is an error message in the URL
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
    echo "<p class='error-message'>$error</p>";
}
?>

<form action="process_login.php" method="POST" class="login-form">
    <label for="usertype" class="form-label">User Type:</label>
    <select id="usertype" name="usertype" class="form-select">
        <option value="Superadmin">Superadmin</option>
        <option value="Admin">Admin</option>
        <option value="User">User</option>
    </select><br><br>
    
    <label for="password" class="form-label">Password:</label>
    <input type="password" id="password" name="password" class="form-input"><br><br>
    
    <label for="unique_code" class="form-label">Unique Code:</label>
    <input type="text" id="unique_code" name="unique_code" class="form-input"><br><br>
    
    <input type="submit" value="Login" class="form-button">
</form>

<?php
// Include footer
include './layout/footer.php';
?>
