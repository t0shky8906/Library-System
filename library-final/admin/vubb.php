<?php
session_start();
include "../conn.php";
include "dash_header.php";

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

// Retrieve the username from the query string parameter
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Retrieve user information
    $userQuery = "SELECT * FROM user WHERE id = '$userId'";
    $userResult = mysqli_query($conn, $userQuery);

    if (!$userResult) {
        $errorMessage = "Failed to retrieve user information: " . mysqli_error($conn);
    } else {
        $user = mysqli_fetch_assoc($userResult);
    }

    // Retrieve the books issued to the user with the specified username
    $issuedBooksQuery = "SELECT i.*, b.title, b.author
                         FROM issued_books i
                         JOIN books b ON i.book_isbn = b.isbn
                         WHERE i.user = '{$user['username']}'";
    $issuedBooksResult = mysqli_query($conn, $issuedBooksQuery);

    if (!$issuedBooksResult) {
        $errorMessage = "Failed to retrieve issued books: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Books</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles */
        *{
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: lightblue;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Books Issued to <?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h1>

        <?php if (isset($errorMessage)) { ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php } ?>

        <table>
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                    <th>Return Status</th>
                    <th>Fine</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($book = mysqli_fetch_assoc($issuedBooksResult)) { ?>
                    <tr>
                        <td><?php echo $book['book_isbn']; ?></td>
                        <td><?php echo $book['title']; ?></td>
                        <td><?php echo $book['author']; ?></td>
                        <td><?php echo $book['requestTime']; ?></td>
                        <td><?php echo $book['dateApproved']; ?></td>
                        <td><?php echo $book['returnDate']; ?></td>
                        <td><?php echo $book['returnStatus']; ?></td>
                        <td><?php echo $book['fine']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
