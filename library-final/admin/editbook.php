<?php
// Database connection code
include "../conn.php";
include "dash_header.php";

// Function to delete an image file
function deleteImageFile($imagePath) {
    if (file_exists($imagePath)) {
        if (unlink($imagePath)) {
            echo "";
        } else {
            echo "Failed to delete the image.";
        }
    } else {
        echo "Image not found.";
    }
}

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
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        // Retrieve the current image from the database
        $query = "SELECT image FROM books WHERE isbn='$isbn'";
        $result = mysqli_query($conn, $query);
        $book = mysqli_fetch_assoc($result);
        $currentImage = $book['image'];

        // Determine the target folders
        $targetFolders = array(
            __DIR__ . "/../books_img",             // First books_img folder (index)
            __DIR__ . "/../user/books_img",        // Second books_img folder (user)
            __DIR__ . "/../admin/books_img"        // Third books_img folder (admin)
        );

        // Loop through each target folder and delete the current image file
        foreach ($targetFolders as $targetFolder) {
            $currentImagePath = $targetFolder . "/" . basename($currentImage);

            // Delete the current image file
            deleteImageFile($currentImagePath);
        }

        // Upload and replace the image file
        $image = $_FILES['image']['name'];
        $tempImage = $_FILES['image']['tmp_name'];
        $imageName = "books_img/" . $image;

        // Loop through each target folder and copy the uploaded file
        foreach ($targetFolders as $targetFolder) {
            $currentImagePath = $targetFolder . "/" . basename($image);

            // Copy the uploaded file to the selected folder
            copy($tempImage, $currentImagePath);
        }
    }

    // Prepare and execute the SQL query
    $query = "UPDATE books SET title='$title', author='$author', category='$category', datepublished='$datepublished', copies=$copies, status='$status'";

    // Check if an image file is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $query .= ", image='$imageName'";
    }

    $query .= " WHERE isbn='$isbn'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        // Book updated successfully
        echo "Book updated successfully.";
    } else {
        // Failed to update book
        echo "Failed to update book. Please try again.";
    }
}

// Check if ISBN is provided
if (isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];

    // Fetch book details from the database
    $query = "SELECT * FROM books WHERE isbn='$isbn'";
    $result = mysqli_query($conn, $query);
    $book = mysqli_fetch_assoc($result);

    // Check if book exists
    if ($book) {
        $title = $book['title'];
        $author = $book['author'];
        $category = $book['category'];
        $datepublished = $book['datepublished'];
        $copies = $book['copies'];
        $status = $book['status'];
        $image = $book['image'];

        echo '<div class="container">';
        echo '<h2>Edit Book</h2>';
        echo '<form method="post" action="" enctype="multipart/form-data">';
        echo '<div class="form-group">';
        echo '<label>ISBN:</label>';
        echo '<input type="text" name="isbn" class="form-control" value="' . $isbn . '" readonly>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label>Title:</label>';
        echo '<input type="text" name="title" class="form-control" value="' . $title . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label>Author:</label>';
        echo '<input type="text" name="author" class="form-control" value="' . $author . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label>Category:</label>';
        echo '<input type="text" name="category" class="form-control" value="' . $category . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label>Date Published:</label>';
        echo '<input type="date" name="datepublished" class="form-control" value="' . $datepublished . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label>Copies:</label>';
        echo '<input type="number" name="copies" class="form-control" value="' . $copies . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label>Status:</label>';
        echo '<input type="text" name="status" class="form-control" value="' . $status . '" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label>Current Image:</label>';
        echo '<img src="../' . $image . '" alt="' . $title . '" style="max-height: 300px;"><br>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label>New Image:</label>';
        echo '<input type="file" name="image" class="form-control-file">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<input type="submit" name="submit" value="Update" class="btn btn-primary">';
        echo '</div>';
        echo '</form>';
        echo '</div>';
    } else {
        // Book not found
        echo 'Book not found.';
    }
} else {
    // No ISBN provided
    echo 'No ISBN provided.';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library System - Edit Book</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
