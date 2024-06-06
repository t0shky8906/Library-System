<?php
// Database connection code
include "../conn.php";
include "dash_header.php";

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $datepublished = $_POST['datepublished'];
    $copies = $_POST['copies'];
    $status = $_POST['status'];

    // Check if an image file is uploaded
    if (isset($_FILES['image'])) {
        $image = $_FILES['image']['name'];
        $tempImage = $_FILES['image']['tmp_name'];
        $imageName = "books_img/" . $image;

        // Determine the target folders
        $targetFolders = array(
            "../books_img",                        // First book_img folder
            "../user/books_img",                   // Second book_img folder
            "../admin/books_img"                   // Third book_img folder
        );

        foreach ($targetFolders as $targetFolder) {
            $imagePath = $targetFolder . "/" . $image;

            // Copy the uploaded file to the selected folder
            copy($tempImage, $imagePath);
        }
    }

    // Prepare and execute the SQL query
    $query = "INSERT INTO books (isbn, title, author, category, datepublished, copies, status, image)
              VALUES ('$isbn', '$title', '$author', '$category', '$datepublished', $copies, '$status', '$imageName')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Book added successfully
        echo "Book added successfully.";
    } else {
        // Failed to add book
        echo "Failed to add book. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library System - Add Book</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles for the add book form */
        /* ... */
        *{
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <!-- Add Book Form -->
    <div class="container">
        <div class="content">
            <h2>Add Book</h2>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label>ISBN:</label>
                    <input type="text" name="isbn" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Author:</label>
                    <input type="text" name="author" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Category:</label>
                    <input type="text" name="category" class="form-control">
                </div>
                <div class="form-group">
                    <label>Date Published:</label>
                    <input type="date" name="datepublished" class="form-control">
                </div>
                <div class="form-group">
                    <label>Copies:</label>
                    <input type="number" name="copies" class="form-control">
                </div>
                <div class="form-group">
                    <label>Status:</label>
                    <input type="text" name="status" class="form-control">
                </div>
                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image" class="form-control-file">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Add Book" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <!-- End of Add Book Form -->

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
