<?php
// Include header
$pageTitle = "Login"; // Set the page title dynamically
include './layout/header.php';
?>

<h2>Login</h2>
<form action="process_login.php" method="POST" class="login-form" onsubmit="return validateForm()">
    <div id="error-message" style="color: red; margin-bottom: 10px;"></div>

    <label for="usertype" class="form-label">User Type:</label>
    <select id="usertype" name="usertype" class="form-select">
        <option value="">Select User Type</option>
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

<script>
function validateForm() {
    var usertype = document.getElementById('usertype').value;
    var password = document.getElementById('password').value;
    var unique_code = document.getElementById('unique_code').value;
    var errorMessage = "";

    if (usertype == '') {
        errorMessage += "Please select a User Type.<br>";
    }
    if (password == '') {
        errorMessage += "Please enter your Password.<br>";
    }
    if (unique_code == '') {
        errorMessage += "Please enter your Unique Code.<br>";
    }

    if (errorMessage !== "") {
        document.getElementById('error-message').innerHTML = errorMessage;
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}
</script>

<?php
// Include footer
include './layout/footer.php';
?>
