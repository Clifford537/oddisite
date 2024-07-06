<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    header("Location: login.php");
    exit();
}

include 'dbconnection.php';

// Fetch total number of device visits
$sql_total_devices = "SELECT COUNT(DISTINCT ip_address) AS total_devices FROM user_actions";
$result_total_devices = $conn->query($sql_total_devices);
$total_devices = $result_total_devices->fetch_assoc()['total_devices'];

// Fetch total number of users who logged in
$sql_total_users = "SELECT COUNT(DISTINCT user_id) AS total_users FROM user_actions";
$result_total_users = $conn->query($sql_total_users);
$total_users = $result_total_users->fetch_assoc()['total_users'];

// Fetch user actions
$sql_user_actions = "SELECT ua.user_id, u.username, ua.action, ua.ip_address, ua.device_name, ua.device_type, ua.browser_type, ua.network_provider, ua.timestamp 
                     FROM user_actions ua
                     JOIN users u ON ua.user_id = u.id
                     ORDER BY ua.timestamp DESC";
$result_user_actions = $conn->query($sql_user_actions);

include 'layout/header.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Site Analytics</h1>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Devices Visited</h5>
                    <p class="card-text"><?= $total_devices ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users Logged In</h5>
                    <p class="card-text"><?= $total_users ?></p>
                </div>
            </div>
        </div>
    </div>

    <h2>User Actions</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Action</th>
                <th>IP Address</th>
                <th>Device Name</th>
                <th>Device Type</th>
                <th>Browser Type</th>
                <th>Network Provider</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_user_actions->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['action']) ?></td>
                    <td><?= htmlspecialchars($row['ip_address']) ?></td>
                    <td><?= htmlspecialchars($row['device_name']) ?></td>
                    <td><?= htmlspecialchars($row['device_type']) ?></td>
                    <td><?= htmlspecialchars($row['browser_type']) ?></td>
                    <td><?= htmlspecialchars($row['network_provider']) ?></td>
                    <td><?= htmlspecialchars($row['timestamp']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
include 'layout/footer.php';
$conn->close();
?>
