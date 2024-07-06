<?php
session_start();

// Include database connection
include '../dbconnection.php';

// Check if user is logged in and is admin or superadmin
if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    header("Location: login.php");
    exit();
}

$isSuperadmin = ($_SESSION['usertype'] === 'SU');
$isAdmin = ($_SESSION['usertype'] === 'Admin');

$pageTitle = "View Matches";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colloh Best Free Odds</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7843741160373139"
     crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <a class="navbar-brand" style="margin: 0 auto; display: block; text-align: center;" href="#">COLLOH BEST FREE ODDS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
            
                    <li>
                    <a class="nav-link text-white" href="../jackpots">
                            <span><i class="fas fa-sig1n-in-alt text-warning"></i> Jackpots </span>
                        </a>
                    </li>
                    <!-- Login Button with Icon -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../index">
                            <span> league</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    

    <?php
function confirmDelete($id) {
    return "onclick=\"return confirm('Are you sure you want to delete match ID $id?')\"";
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $match_id = $_GET['id'];
    $sql_delete = "DELETE FROM matches WHERE match_id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $match_id);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Match ID ' . $match_id . ' deleted successfully.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error deleting match ID ' . $match_id . ': ' . $conn->error . '</div>';
    }
    $stmt->close();
}

// Handle inline update action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $match_id = $_POST['id'];
    $column = $_POST['column'];
    $new_value = $_POST['newValue'];

    $sql_update = "UPDATE matches SET $column = ? WHERE match_id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("si", $new_value, $match_id);
    if ($stmt->execute()) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => $conn->error));
    }
    exit();
}

// Fetch all matches
$sql_select = "SELECT match_id, type, team_1, team_2, team_1_odds, team_2_odds, winteam, match_date FROM matches";
$result = $conn->query($sql_select);
?>

<div class="container">
    <h2>All Matches</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Team 1</th>
                <th>Team 2</th>
                <th>Odds Team 1</th>
                <th>Odds Team 2</th>
                <th>Winning Team</th>
                <th>Date Played</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['match_id']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td contenteditable="true" class="editable" data-id="<?php echo $row['match_id']; ?>" data-column="team_1"><?php echo $row['team_1']; ?></td>
                    <td contenteditable="true" class="editable" data-id="<?php echo $row['match_id']; ?>" data-column="team_2"><?php echo $row['team_2']; ?></td>
                    <td contenteditable="true" class="editable" data-id="<?php echo $row['match_id']; ?>" data-column="team_1_odds"><?php echo $row['team_1_odds']; ?></td>
                    <td contenteditable="true" class="editable" data-id="<?php echo $row['match_id']; ?>" data-column="team_2_odds"><?php echo $row['team_2_odds']; ?></td>
                    <td contenteditable="true" class="editable" data-id="<?php echo $row['match_id']; ?>" data-column="winteam"><?php echo $row['winteam']; ?></td>
                    <td contenteditable="true" class="editable" data-id="<?php echo $row['match_id']; ?>" data-column="match_date"><?php echo $row['match_date']; ?></td>
                    <td>
                        <button onclick="updateMatch(<?php echo $row['match_id']; ?>)" class="btn btn-primary">Update</button>
                        <a href="?action=delete&id=<?php echo $row['match_id']; ?>" class="btn btn-danger" <?php echo confirmDelete($row['match_id']); ?>>Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../layout/footer.php'; ?>

<script>
    // JavaScript for inline editing
    function updateMatch(id) {
        const row = document.querySelector(`.editable[data-id="${id}"]`);
        const column = row.getAttribute("data-column");
        const newValue = row.textContent.trim();

        fetch("view_plans.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                update: true,
                id: id,
                column: column,
                newValue: newValue
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                row.classList.add("bg-success");
                setTimeout(function() {
                    row.classList.remove("bg-success");
                }, 1000);
            } else {
                row.classList.add("bg-danger");
                setTimeout(function() {
                    row.classList.remove("bg-danger");
                }, 1000);
                console.error("Error:", data.error);
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    }
</script>

<?php
// Close database connection
$conn->close();
?>
