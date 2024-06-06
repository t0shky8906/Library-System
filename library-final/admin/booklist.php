<?php
// Database connection code
include "../conn.php";
include "dash_header.php";

// Fetch all books from the database
$query = "SELECT * FROM books";
$result = mysqli_query($conn, $query);

// Check if any books exist
if (mysqli_num_rows($result) > 0) {
    echo '<div class="container">';
    echo '<h2>Book List</h2>';

    // Search form
    echo '<form method="get" action="booklist.php" class="mb-4">';
    echo '<div class="input-group">';
    echo '<input type="text" name="search" class="form-control" placeholder="Search books...">';
    echo '<div class="input-group-append">';
    echo '<button type="submit" class="btn btn-primary">Search</button>';
    echo '</div>';
    echo '</div>';
    echo '</form>';

    // Process search query if submitted
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $searchQuery = "SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR isbn LIKE '%$search%'";
    $searchResult = mysqli_query($conn, $searchQuery);

    // Display search results or all books
    $books = mysqli_num_rows($searchResult) > 0 ? $searchResult : $result;

    // Display each book in a modified layout
    while ($row = mysqli_fetch_assoc($books)) {
        $isbn = $row['isbn'];
        $title = $row['title'];
        $author = $row['author'];
        $category = $row['category'];
        $datepublished = $row['datepublished'];
        $copies = $row['copies'];
        $status = $row['status'];
        $image = $row['image'];

        // Generate the image path
        $imagePath = "../" . $image;

        echo '<div class="card mb-3">';
        echo '<div class="row no-gutters">';
        echo '<div class="col-md-4">';
        echo '<img src="' . $imagePath . '" class="card-img" alt="' . $title . '" style="max-height: 300px;">';
        echo '</div>';
        echo '<div class="col-md-8">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $title . '</h5>';
        echo '<p class="card-text">Author: ' . $author . '</p>';
        echo '<p class="card-text">Category: ' . $category . '</p>';
        echo '<p class="card-text">Date Published: ' . $datepublished . '</p>';
        echo '<p class="card-text">Copies: ' . $copies . '</p>';
        echo '<p class="card-text">Status: ' . $status . '</p>';
        echo '<a href="editbook.php?isbn=' . $isbn . '" class="btn btn-primary">Edit</a>';
        echo '<a href="deletebook.php?isbn=' . $isbn . '" class="btn btn-danger ml-2">Delete</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
} else {
    // No books found
    echo 'No books found.';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library System - Book List</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style type="text/css">
        *{
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
