<?php
session_start();
ob_start(); // Start output buffering
include "../conn.php";
include "dash_header.php";

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

$user = $_SESSION['username'];

// Retrieve issued books for the logged-in user
$issuedBooksQuery = "SELECT * FROM issued_books WHERE user = '$user'";
$issuedBooksResult = mysqli_query($conn, $issuedBooksQuery);

if (!$issuedBooksResult) {
    $errorMessage = "Failed to retrieve issued books: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Books</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles */
        *{
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .book-card {
            display: inline-block;
            width: 300px;
            margin: 10px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            background-color: #f7f7f7;
        }

        .book-card img {
            max-width: 200px;
            height: auto;
            margin-bottom: 10px;
        }

        .book-card h4 {
            margin-bottom: 5px;
        }

        .book-card p {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .book-card .fine {
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Books</h1>

        <?php if (isset($errorMessage)) { ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php } ?>

        <?php while ($book = mysqli_fetch_assoc($issuedBooksResult)) {
            $bookISBN = $book['book_isbn'];
            $bookQuery = "SELECT * FROM books WHERE isbn = '$bookISBN'";
            $bookResult = mysqli_query($conn, $bookQuery);
            $bookData = mysqli_fetch_assoc($bookResult);
            ?>

            <div class="book-card">
                <img src="<?php echo $bookData['image']; ?>" alt="Book Cover">
                <h4>Book ISBN: <?php echo $book['book_isbn']; ?></h4>
                <p>Issued On: <?php echo $book['dateApproved']; ?></p>
                <p>Return Date: <?php echo $book['returnDate']; ?></p>
                <p>Return Status: <?php echo $book['returnStatus']; ?></p>
                <p class="fine">Fine: <?php echo $book['fine']; ?></p>
            </div>
        <?php } ?>
    </div>
</body>
</html>
