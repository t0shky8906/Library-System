<?php
session_start(); // Start the session
include "../conn.php";
include "dash_header.php";

// Check if the user is logged in
// If not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

// Retrieve user information from the database
$username = $_SESSION['username'];
$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['book_id'])) {
        $bookId = $_POST['book_id'];

        // Check if the user has already borrowed a copy of the book
        $checkQuery = "SELECT * FROM pending_book_requests WHERE user = '$username' AND book_isbn = '$bookId'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            // User has already borrowed a copy of the book
            $errorMessage = "You have already borrowed a copy of this book.";
        } else {
            // Check if the user has a rejected request for the book
            $rejectedQuery = "SELECT * FROM pending_book_requests WHERE user = '$username' AND book_isbn = '$bookId' AND request_status = 'Rejected'";
            $rejectedResult = mysqli_query($conn, $rejectedQuery);

            if ($rejectedResult && mysqli_num_rows($rejectedResult) > 0) {
                // User's previous request for the book was rejected
                $errorMessage = "Your previous request for this book was rejected. You cannot send another request.";
            } else {
                // Proceed with borrowing the book
                // Retrieve book information
                $bookQuery = "SELECT * FROM books WHERE isbn = $bookId";
                $bookResult = mysqli_query($conn, $bookQuery);

                if ($bookResult && mysqli_num_rows($bookResult) > 0) {
                    $book = mysqli_fetch_assoc($bookResult);

                    // Check if there are available copies of the book
                    if ($book['copies'] > 0) {
                        // Update the book's status and decrease the number of copies
                        $updateQuery = "UPDATE books SET copies = copies - 1 WHERE isbn = $bookId";
                        $updateResult = mysqli_query($conn, $updateQuery);

                        if ($updateResult) {
                            // Book successfully borrowed
                            $successMessage = "Book borrowed successfully!";

                            // Save the borrowing request in the pending_book_requests table
                            $insertQuery = "INSERT INTO pending_book_requests (user, book_isbn, time) VALUES ('$username', '$bookId', NOW())";
                            mysqli_query($conn, $insertQuery);
                        } else {
                            // Failed to borrow book
                            $errorMessage = "Failed to borrow the book. Please try again.";
                        }
                    } else {
                        // No available copies of the book
                        $updateQuery = "UPDATE books SET status = 'Not Available' WHERE isbn = $bookId";
                        $errorMessage = "No available copies of the book.";
                        mysqli_query($conn, $updateQuery);
                    }
                } else {
                    // Book not found
                    $errorMessage = "The selected book is not available.";
                }
            }
        }
    }
}

// Retrieve the list of available books from the database
$booksQuery = "SELECT b.* FROM books b LEFT JOIN pending_book_requests p ON b.isbn = p.book_isbn AND p.user = '$username' WHERE b.status = 'Available' AND p.book_isbn IS NULL";
$booksResult = mysqli_query($conn, $booksQuery);

if (!$booksResult) {
    // Query execution failed, display the error message
    $errorMessage = "Failed to retrieve available books: " . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Borrow a Book</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles */
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        .form-btn {
            padding: 10px 20px;
            font-size: 18px;
            background-color: blue;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-btn:hover {
            background-color: #23272b;
        }

        .message {
            margin-top: 20px;
            color: green;
        }

        .error-message {
            margin-top: 20px;
            color: red;
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

        .col-md-12 {
            text-align: center;
            color: red;
        }

        .alert {
            position: relative;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            align-items: center;
            width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Borrow a Book</h1>

        <?php if (isset($successMessage)) { ?>
            <div class="alert alert-success" role="alert" style="color: black; font-weight: bold; background-color: #46d141; border-color: #46d141;">
                <?php echo $successMessage; ?></div>
        <?php } ?>

        <?php if (isset($errorMessage)) { ?>
            <div class="alert alert-danger" role="alert" style="color: black; font-weight: bold; background-color: #ff4b5c; border-color: #f5c6cb;">
                <?php echo $errorMessage; ?></div>
        <?php } ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="book">Select a book:</label>
                <select id="book" name="book_id" required>
                    <option value="">Select a book</option>
                    <?php
                    // Display the available books as options
                    while ($book = mysqli_fetch_assoc($booksResult)) {
                        echo '<option value="' . $book['isbn'] . '">' . $book['title'] . ' by ' . $book['author'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Borrow" class="form-btn">
            </div>
        </form>

        <form method="get" action="">
            <div class="form-group">
                <label for="search">Search for a book:</label>
                <input type="text" id="search" name="search" placeholder="Enter book title or author">
                <input type="submit" name="search_submit" value="Search" class="form-btn">
            </div>
        </form>
    </div>
    <h1>Available Books</h1>
    <div class="row">
        <?php
        // Retrieve search query if submitted
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

        // Retrieve search results from the database
        $searchResult = mysqli_query($conn, "SELECT * FROM books WHERE copies != 0 AND (title LIKE '%$searchQuery%' OR author LIKE '%$searchQuery%')");

        if ($searchResult && mysqli_num_rows($searchResult) > 0) {
            // Display search results
            while ($book = mysqli_fetch_assoc($searchResult)) {
                echo '<div class="col-md-3">
                        <div class="book-card">
                            <img src="' . $book['image'] . '" alt="' . $book['title'] . '">
                            <h4>' . $book['title'] . '</h4>
                            <p>By ' . $book['author'] . '</p>
                            <p>Copies: ' . $book['copies'] . '</p>
                        </div>
                    </div>';
            }
        } else {
            // No search results found
            echo '<div class="col-md-12">
                    <p>No books found.</p>
                </div>';
        }
        ?>
    </div>
</body>
</html>
