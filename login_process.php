<?php
// Start the session
session_start();

// Include the database connection
include 'dbconnection.php';

// Helper function to get device name based on user agent
function get_device_name($user_agent) {
    if (preg_match('/mobile/i', $user_agent)) {
        return 'Mobile';
    } elseif (preg_match('/tablet/i', $user_agent)) {
        return 'Tablet';
    } else {
        return 'Desktop';
    }
}

// Function to get client IP address
function get_client_ip() {
    $ip_address = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}

// Function to get browser type from user agent
function get_browser_type($user_agent) {
    if (strpos($user_agent, 'Firefox') !== false) {
        return 'Firefox';
    } elseif (strpos($user_agent, 'Chrome') !== false) {
        return 'Chrome';
    } elseif (strpos($user_agent, 'Safari') !== false) {
        return 'Safari';
    } elseif (strpos($user_agent, 'Edge') !== false) {
        return 'Edge';
    } elseif (strpos($user_agent, 'Opera') !== false) {
        return 'Opera';
    } elseif (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident/') !== false) {
        return 'Internet Explorer';
    } else {
        return 'Unknown';
    }
}

// Function to get network provider (placeholder function)
function get_network_provider($ip_address) {
    // For this example, returning a placeholder value
    // In a real application, use an external service or database lookup to determine network provider
    return 'Unknown Network';
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $usertype = $_POST['usertype'];
    $password = $_POST['password'];
    $unique_code = $_POST['unique_code'];

    // Prepare and execute query to check credentials
    $stmt = $conn->prepare("SELECT u.id, u.username, u.password, ut.usertype 
                            FROM users u
                            INNER JOIN usertypes ut ON u.usertype_id = ut.id
                            WHERE ut.usertype = ? AND u.unique_code = ?");
    $stmt->bind_param("ss", $usertype, $unique_code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $hashed_password, $usertype_name);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Store user information in session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $usertype_name;

            // Log the user action with additional details
            $ip_address = get_client_ip();
            $device_name = gethostbyaddr($ip_address);
            $device_type = get_device_name($_SERVER['HTTP_USER_AGENT']);
            $browser_type = get_browser_type($_SERVER['HTTP_USER_AGENT']);
            $network_provider = get_network_provider($ip_address);
            
            $sql_log = "INSERT INTO user_actions (user_id, action, ip_address, device_name, device_type, browser_type, network_provider, timestamp) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt_log = $conn->prepare($sql_log);
            $action = 'Login';
            $stmt_log->bind_param('issssss', $user_id, $action, $ip_address, $device_name, $device_type, $browser_type, $network_provider);
            $stmt_log->execute();

            // Redirect to dashboard after successful login
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "Invalid usertype or unique code";
    }

    // Close statement and database connection
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
