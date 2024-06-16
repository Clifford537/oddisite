<?php './layout/haeder.php'; ?>
    <h2>Login</h2>
    <form action="login_process.php" method="post">
        <label for="usertype">User Type:</label>
        <select id="usertype" name="usertype">
            <option value="Superadmin">Superadmin</option>
            <option value="Admin">Admin</option>
            <option value="User">User</option>
        </select><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        
        <label for="unique_code">Unique Code:</label>
        <input type="text" id="unique_code" name="unique_code"><br><br>
        
        <input type="submit" value="Login">
    </form>

<?php './layout/footer.php'; ?>
