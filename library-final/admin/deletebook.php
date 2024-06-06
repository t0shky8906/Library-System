<?php
// Database connection code
include "../conn.php";
include "dash_header.php";

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
        $image = $book['image'];

        // Array of target folders to delete the image from
        $targetFolders = array(
            __DIR__ . "/../books_img",             // First books_img folder (index)
            __DIR__ . "/../user/books_img",        // Second books_img folder (user)
            __DIR__ . "/../admin/books_img"        // Third books_img folder (admin)
        );

        // Extract the image filename from the image path
        $filename = basename($image);

        // Loop through each target folder and delete the image file
        foreach ($targetFolders as $targetFolder) {
            $imagePath = $targetFolder . "/" . $filename;

            // Check if the image file exists
            if (file_exists($imagePath)) {
                // Delete the image file
                if (unlink($imagePath)) {
                    echo "";
                } else {
                    echo "Failed to delete the image from $targetFolder.";
                }
            } else {
                echo "Image not found in $targetFolder.";
            }
        }

        // Delete the book from the database
        $deleteQuery = "DELETE FROM books WHERE isbn='$isbn'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            // Book deleted successfully
            echo "Book deleted successfully.";
        } else {
            // Failed to delete book
            echo "Failed to delete book. Please try again.";
        }
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
    <title>Library System - Delete Book</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>