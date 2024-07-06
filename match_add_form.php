<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    header("Location: ../login.php");
    exit();
}

$isSuperadmin = ($_SESSION['usertype'] === 'SU');
$isAdmin = ($_SESSION['usertype'] === 'Admin');
$isUser = ($_SESSION['usertype'] === 'User');
?>
<?php include './layout/header.php'; ?>

<div class="containerj mt-5">
    <h1 class="mb-4">Add a New Match</h1>
    <form id="matchForm" action="match_add.php" method="post" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="type">Match Type:</label>
            <select class="form-control" id="type" name="type" required>
                <option value="">Select Match Type</option>
                <?php
                include 'dbconnection.php';
                $sql = "SELECT type FROM matchtype";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['type'] . "'>" . $row['type'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No Match Types Available</option>";
                }
                $conn->close();
                ?>
            </select>
            <div class="invalid-feedback">
                Please select a match type.
            </div>
        </div>
        
        <div class="form-group">
            <label for="team_1">Team 1:</label>
            <input type="text" class="form-control" id="team_1" name="team_1" required pattern="[A-Za-z][A-Za-z\s]*"
                   title="Please enter letters only with the first letter capitalized" 
                   aria-describedby="team1HelpBlock" maxlength="50">
            <small id="team1HelpBlock" class="form-text text-muted">Enter Team 1 name with letters only.</small>
            <div class="invalid-feedback">
                Please enter Team 1 with letters only (first letter capitalized).
            </div>
        </div>
        
        <div class="form-group">
            <label for="team_2">Team 2:</label>
            <input type="text" class="form-control" id="team_2" name="team_2" required pattern="[A-Za-z][A-Za-z\s]*"
                   title="Please enter letters only with the first letter capitalized"
                   aria-describedby="team2HelpBlock" maxlength="50">
            <small id="team2HelpBlock" class="form-text text-muted">Enter Team 2 name with letters only.</small>
            <div class="invalid-feedback">
                Please enter Team 2 with letters only (first letter capitalized).
            </div>
        </div>
        
        <div class="form-group">
            <label for="team_1_odds">Team 1 Odds:</label>
            <input type="number" step="0.01" class="form-control" id="team_1_odds" name="team_1_odds" required>
            <div class="invalid-feedback">
                Please enter valid Team 1 odds.
            </div>
        </div>
        
        <div class="form-group">
            <label for="team_2_odds">Team 2 Odds:</label>
            <input type="number" step="0.01" class="form-control" id="team_2_odds" name="team_2_odds" required>
            <div class="invalid-feedback">
                Please enter valid Team 2 odds.
            </div>
        </div>
        
        <div class="form-group">
            <label for="winteam">Winning Team:</label>
            <input type="text" class="form-control" id="winteam" name="winteam" required pattern="[A-Za-z][A-Za-z\s]*"
                   title="Please enter letters only with the first letter capitalized"
                   aria-describedby="winteamHelpBlock" maxlength="50">
            <small id="winteamHelpBlock" class="form-text text-muted">Enter Winning Team name with letters only.</small>
            <div class="invalid-feedback">
                Please enter Winning Team with letters only (first letter capitalized).
            </div>
        </div>
        
        <div class="form-group">
            <label for="match_date">Match Date:</label>
            <input type="date" class="form-control" id="match_date" name="match_date" required>
            <div class="invalid-feedback">
                Please select a match date.
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Match</button>
    </form>
</div>

<style>
    /* Custom CSS for form styling */
    body {
        background-color: #f8f9fa;
    }
    
    .containerj {
        max-width: 600px;
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 0 15px;
        margin-left: auto;
        margin-right: auto;
    }
    
    form {
        margin-top: 20px;
    }
    
    label {
        font-weight: bold;
    }
    
    .btn-primary {
        margin-top: 20px;
    }
</style>

<?php include './layout/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('matchForm');
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const team1Input = document.getElementById('team_1');
        const team2Input = document.getElementById('team_2');
        const winteamInput = document.getElementById('winteam');
        const team1OddsInput = document.getElementById('team_1_odds');
        const team2OddsInput = document.getElementById('team_2_odds');
        
        const namePattern = /^[A-Za-z][A-Za-z\s]*$/;
        
        // Validate team names and winning team
        if (!namePattern.test(team1Input.value)) {
            team1Input.classList.add('is-invalid');
            team1Input.focus();
            return;
        } else {
            team1Input.classList.remove('is-invalid');
        }
        
        if (!namePattern.test(team2Input.value)) {
            team2Input.classList.add('is-invalid');
            team2Input.focus();
            return;
        } else {
            team2Input.classList.remove('is-invalid');
        }
        
        if (!namePattern.test(winteamInput.value)) {
            winteamInput.classList.add('is-invalid');
            winteamInput.focus();
            return;
        } else {
            winteamInput.classList.remove('is-invalid');
        }
        
        // Validate odds to be float
        if (isNaN(parseFloat(team1OddsInput.value)) || parseFloat(team1OddsInput.value) <= 0) {
            team1OddsInput.classList.add('is-invalid');
            team1OddsInput.focus();
            return;
        } else {
            team1OddsInput.classList.remove('is-invalid');
        }
        
        if (isNaN(parseFloat(team2OddsInput.value)) || parseFloat(team2OddsInput.value) <= 0) {
            team2OddsInput.classList.add('is-invalid');
            team2OddsInput.focus();
            return;
        } else {
            team2OddsInput.classList.remove('is-invalid');
        }
        
        form.submit();
    });
});
</script>
