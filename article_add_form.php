<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include './layout/header.php'; ?>

<div class="containerj mt-5">
    <h1 class="mb-4">Add an Article</h1>
    <form action="article_add.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title" required>
            <div class="invalid-feedback">
                Please enter a title.
            </div>
        </div>
        
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="4" placeholder="Enter the content" required></textarea>
            <div class="invalid-feedback">
                Please enter the content.
            </div>
        </div>
        
        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" class="form-control" id="author" name="author" placeholder="Enter the author's name">
        </div>
        
        <div class="form-group">
            <label for="published_date">Published Date:</label>
            <input type="date" class="form-control" id="published_date" name="published_date">
        </div>
        
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" class="form-control" id="category" name="category" placeholder="Enter the category">
        </div>
        
        <div class="form-group">
            <label for="image">Select Image:</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>
        
        <button type="submit" class="btn btn-primary">Add Article</button>
    </form>
</div>

<style>
    /* Custom CSS for form styling */
 
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

<script>
    // JavaScript to capitalize the first letter of inputs
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('title').addEventListener('input', function() {
            this.value = capitalizeFirstLetter(this.value);
        });
        
        document.getElementById('author').addEventListener('input', function() {
            this.value = capitalizeFirstLetter(this.value);
        });
        
        document.getElementById('category').addEventListener('input', function() {
            this.value = capitalizeFirstLetter(this.value);
        });
        
        function capitalizeFirstLetter(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    });
</script>

<?php include './layout/footer.php'; ?>
