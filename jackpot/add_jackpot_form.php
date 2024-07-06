<?php
// Include database connection or initialization script here
include '../dbconnection.php';

// Fetch jackpottypes from the database
$query = "SELECT id, type FROM jackpottypes";
$result = $conn->query($query);

$jackpottypes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jackpottypes[] = $row;
    }
}

$conn->close();
?>
<?php session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {

    header("Location: ../login.php");
    exit();
} ?>

<?php
// Include the header file
include '../layout/header.php';
?>

<h2 class="form-heading">Add Jackpot</h2>
<style>
    .register-form {
        max-width: 430px;
        margin: 20px auto;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-height: fit-content;
    }

    .register-form label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .register-form input[type="text"],
    .register-form input[type="date"],
    .register-form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .register-form input[type="submit"] {
        width: 50%;
        padding: 12px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        display: block;
        margin: 0 auto;
    }

    .register-form input[type="submit"]:hover {
        background-color: #218838;
    }

    .form-heading {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }
</style>

<form action="add_jackpot.php" method="post" class="register-form">
    <label for="jackpottype">Jackpot Type:</label>
    <select id="jackpottype" name="jackpottype_id" required>
        <?php foreach ($jackpottypes as $jackpottype): ?>
            <option value="<?= htmlspecialchars($jackpottype['id']) ?>"><?= htmlspecialchars($jackpottype['type']) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="team1">Team 1:</label>
    <input type="text" id="team1" name="team1" placeholder="Enter Team 1" required>

    <label for="team2">Team 2:</label>
    <input type="text" id="team2" name="team2" placeholder="Enter Team 2" required>

    <label for="win">Winning Team/Outcome:</label>
    <input type="text" id="win" name="win" placeholder="Enter Winning Team/Outcome" required>

    <label for="date_played">Date Played:</label>
    <input type="date" id="date_played" name="date_played" required>

    <input type="submit" value="Add Jackpot">
</form>

<?php
// Include the footer file
include '../layout/footer.php';
?>

<script>
    // JavaScript to capitalize the first letter and restrict to text input
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('team1').addEventListener('input', function() {
            this.value = capitalizeFirstLetter(this.value);
        });

        document.getElementById('team2').addEventListener('input', function() {
            this.value = capitalizeFirstLetter(this.value);
        });

        document.getElementById('win').addEventListener('input', function() {
            this.value = capitalizeFirstLetter(this.value);
        });

        function capitalizeFirstLetter(str) {
            return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
        }

        // Restrict input to text only for specified fields
        var textOnlyFields = ['team1', 'team2', 'win'];
        textOnlyFields.forEach(function(field) {
            var input = document.getElementById(field);
            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            });
        });
    });
</script>
