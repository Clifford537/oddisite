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

$pageTitle = "View Jackpots";
?>

<?php include '../layout/header.php'; ?>

<div class="container">
    <h2>All Jackpots</h2>

    <?php
    // Function to display a confirmation dialog for delete action
    function confirmDelete($id) {
        return "onclick=\"return confirm('Are you sure you want to delete jackpot ID $id?')\"";
    }

    // Handle delete action
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $jackpot_id = $_GET['id'];
        $sql_delete = "DELETE FROM jackpots WHERE id = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param("i", $jackpot_id);
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Jackpot ID ' . $jackpot_id . ' deleted successfully.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error deleting jackpot ID ' . $jackpot_id . ': ' . $conn->error . '</div>';
        }
        $stmt->close();
    }

    // Handle update action
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $jackpot_id = $_POST['id'];
        $team1 = $_POST['team1'];
        $team2 = $_POST['team2'];
        $win = $_POST['win'];
        $date_played = $_POST['date_played'];

        $sql_update = "UPDATE jackpots SET team1 = ?, team2 = ?, win = ?, date_played = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ssssi", $team1, $team2, $win, $date_played, $jackpot_id);
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Jackpot ID ' . $jackpot_id . ' updated successfully.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error updating jackpot ID ' . $jackpot_id . ': ' . $conn->error . '</div>';
        }
        $stmt->close();
    }

    // Fetch all jackpots
    $sql_select = "SELECT id, jackpottype_id, team1, team2, win, date_played FROM jackpots";
    $result = $conn->query($sql_select);
    ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Jackpot Type</th>
                <th>Team 1</th>
                <th>Team 2</th>
                <th>Win</th>
                <th>Date Played</th>
                <?php if ($isAdmin || $isSuperadmin): ?>
                    <th>Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['jackpottype_id']; ?></td> <!-- Replace with actual jackpot type name -->
                    <td contenteditable="true" class="editable" data-id="<?php echo $row['id']; ?>" data-column="team1"><?php echo $row['team1']; ?></td>
                    <td contenteditable="true" class="editable" data-id="<?php echo $row['id']; ?>" data-column="team2"><?php echo $row['team2']; ?></td>
                    <td contenteditable="true" class="editable" data-id="<?php echo $row['id']; ?>" data-column="win"><?php echo $row['win']; ?></td>
                    <td contenteditable="true" class="editable" data-id="<?php echo $row['id']; ?>" data-column="date_played"><?php echo $row['date_played']; ?></td>
                    <?php if ($isAdmin || $isSuperadmin): ?>
                        <td>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="jackpottype_id" value="<?php echo $row['jackpottype_id']; ?>">
                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                                <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger" <?php echo confirmDelete($row['id']); ?>>Delete</a>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

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
                    <!-- OdiPlans Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="../index" id="odiPlansDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Super PLans
                        </a>
                        <div class="dropdown-menu" aria-labelledby="odiPlansDropdown">
                            <a class="dropdown-item" href="../index">PLAN 1</a>
                            <a class="dropdown-item" href="../index">PLAN 2</a>
                            <a class="dropdown-item" href="../index">PLAN 3</a>
                            <a class="dropdown-item" href="../index">Jackpot</a>
                        </div>
                    </li>
                    <li>
                    <a class="nav-link text-white" href="../jackpots">
                            <span><i class="fas fa-sig1n-in-alt text-warning"></i> Jackpots </span>
                        </a>
                    </li>
                    <!-- Login Button with Icon -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../login.php">
                            <span><i class="fas fa-sign-in-alt text-warning"></i> Login</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


<script>
    // JavaScript for inline editing
    document.addEventListener("DOMContentLoaded", function() {
        const editables = document.querySelectorAll(".editable");

        editables.forEach(function(editable) {
            editable.addEventListener("blur", function() {
                const id = editable.getAttribute("data-id");
                const column = editable.getAttribute("data-column");
                const newValue = editable.textContent.trim();

                fetch("update_jackpot.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id: id,
                        column: column,
                        newValue: newValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        editable.classList.add("bg-success");
                        setTimeout(function() {
                            editable.classList.remove("bg-success");
                        }, 1000);
                    } else {
                        editable.classList.add("bg-danger");
                        setTimeout(function() {
                            editable.classList.remove("bg-danger");
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
            });
        });
    });
</script>

<?php
// Close database connection
$conn->close();
?>
