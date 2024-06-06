<?php
session_start();
include "../conn.php";
include "dash_header.php";

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

// Retrieve all issued books
$issuedBooksQuery = "SELECT * FROM issued_books";
$issuedBooksResult = mysqli_query($conn, $issuedBooksQuery);

if (!$issuedBooksResult) {
    $errorMessage = "Failed to retrieve issued books: " . mysqli_error($conn);
}

// Handle search form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];

    // Construct the search query
    $searchQuery = "SELECT * FROM issued_books WHERE user LIKE '%$searchTerm%' OR book_isbn LIKE '%$searchTerm%' OR returnStatus LIKE '%$searchTerm%'";
    $issuedBooksResult = mysqli_query($conn, $searchQuery);

    if (!$issuedBooksResult) {
        $errorMessage = "Search failed: " . mysqli_error($conn);
    }
}

// Handle edit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $issuedId = $_POST['issued_id'];
    $returnDate = $_POST['returnDate'];
    $fine = $_POST['fine'];
    $returnStatus = $_POST['returnStatus'];

    // Update the return date, fine, and return status in the issued_books table
    $updateQuery = "UPDATE issued_books SET returnDate = '$returnDate', fine = '$fine', returnStatus = '$returnStatus' WHERE issued_id = $issuedId";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        header("Location: issuedbooks.php");
        exit();
    } else {
        $errorMessage = "Failed to update the book information: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issued Books</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles */
        *{
            font-family: Arial, sans-serif;
        }
        .search-button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        body {
            background-color: #f7f7f7;
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
            width: 200px;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }

        .book-card h4 {
            margin-bottom: 5px;
        }

        .book-card p {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-input {
            padding: 5px;
            width: 200px;
        }

        .search-button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .edit-button {
            padding: 5px 10px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Issued Books</h1>

        <form class="search-form" method="post" action="">
            <input type="text" name="searchTerm" placeholder="Search..." class="search-input">
            <input type="submit" name="search" value="Search" class="search-button">
        </form>

        <?php if (isset($errorMessage)) { ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php } ?>

        <?php while ($book = mysqli_fetch_assoc($issuedBooksResult)) { ?>
            <div class="book-card">
                <h4>Issued ID: <?php echo $book['issued_id']; ?></h4>
                <p>User: <?php echo $book['user']; ?></p>
                <p>Book ISBN: <?php echo $book['book_isbn']; ?></p>
                <p>Request Time: <?php echo $book['requestTime']; ?></p>
                <p>Date Approved: <?php echo $book['dateApproved']; ?></p>
                <form method="post" action="">
                    <input type="hidden" name="issued_id" value="<?php echo $book['issued_id']; ?>">
                    <label for="returnDate">Return Date:</label>
                    <input type="date" name="returnDate" value="<?php echo $book['returnDate']; ?>">
                    <label for="fine">Fine:</label>
                    <input type="number" name="fine" value="<?php echo $book['fine']; ?>">
                    <label for="returnStatus">Return Status:</label>
                    <input type="text" name="returnStatus" value="<?php echo $book['returnStatus']; ?>">
                    <input type="submit" name="edit" value="Save" class="edit-button">
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>