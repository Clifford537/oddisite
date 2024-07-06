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
    <style>
        .navbar-nav .nav-link {
            font-size: 0.875rem; /* Smaller font size for navigation links */
        }
        .navbar-brand {
            font-size: 1.25rem; /* Adjust brand font size */
        }
        @media (max-width: 576px) {
            .navbar-brand {
                text-align: center;
                margin: 0 auto;
                display: block;
            }
            .navbar-nav {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <a class="navbar-brand" href="../index">COLLOH BEST FREE ODDS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- OdiPlans Dropdown Menu -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../index">
                            League Predictions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../articles">
                            Articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../jackpots">
                            Jackpots
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../aboutus">
                            About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../layout/footer">
                            Privacy Policy
                        </a>
                    </li>
                    <!-- Login Button with Icon -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../login.php">
                            <span><i class="fas fa-sign-in-alt text-warning"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

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
