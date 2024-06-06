<?php
include "conn.php";
include "header.php";
session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Library</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS styles */
        .container {
            margin-top: 20px;
        }
        .book-card {
            display: inline-block;
            width: 200px;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        .book-card img {
            width: 150px;
            height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .book-card h4 {
            margin-bottom: 5px;
        }
        .book-card p {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book Library</h2>
        <div class="row">
            <?php

            // Query the books table to fetch book records
            $sql = "SELECT * FROM books";
            $result = mysqli_query($conn, $sql);

            // Iterate through each book record
            while ($row = mysqli_fetch_assoc($result)) {
                $title = $row['title'];
                $author = $row['author'];
                $category = $row['category'];
                $status = $row['status'];
                $image = $row['image'];

                // Display book information in a card
                echo '<div class="col-md-4">
                        <div class="book-card">
                            <img src="'.$image.'" alt="'.$title.'">
                            <h4>'.$title.'</h4>
                            <p>By '.$author.'</p>
                            <p>Category: '.$category.'</p>
                            <p>Status: '.$status.'</p>';

                // Check if user is logged in
                if (isset($_SESSION['user_id'])) {
                    // Display borrow button
                    echo '<a class="btn btn-primary" href="#"></a>';
                } else {
                    // Display login button
                    echo '<a class="btn btn-primary" href="user/user_register.php">Borrow</a>';
                }

                echo '</div>
                    </div>';

            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
