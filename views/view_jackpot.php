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

<?php include '../layout/footer.php'; ?>

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
