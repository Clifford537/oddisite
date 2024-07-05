<?php  session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username']) || !isset($_SESSION['usertype'])) {

    header("Location: login.php");
    exit();
} ?>
<?php include './layout/header.php'; ?>
<body>
    <h1>Add an Article</h1>
    <form action="article_add.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>
        
        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required></textarea><br><br>
        
        <label for="author">Author:</label><br>
        <input type="text" id="author" name="author"><br><br>
        
        <label for="published_date">Published Date:</label><br>
        <input type="date" id="published_date" name="published_date"><br><br>
        
        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category"><br><br>
        
        <label for="image">Select Image:</label><br>
        <input type="file" id="image" name="image" accept="image/*"><br><br>
        
        <input type="submit" value="Add Article">
    </form>
    <?php include './layout/footer.php'; ?>
