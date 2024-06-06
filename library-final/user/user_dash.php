<?php
session_start(); // Start the session
include "dash_header.php";
include "../conn.php";

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Dashboard</title>
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
            text-align: center  ;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .user-info {
            margin-bottom: 20px;
        }

        .user-info h2 {
            margin-bottom: 10px;
        }

        .user-info p {
            margin-bottom: 5px;
        }
    </style>
</head>
<hr>
<body>
    <div class="container">
        <h1>Welcome to the Page - Turner Library Dashboard, <?php echo $user['firstname']; ?>!</h1>

        <div class="user-info">
            <h2>User Information</h2>
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Full Name:</strong> <?php echo $user['firstname'] . ' ' . $user['MI'] . ' ' . $user['lastname']; ?></p>
            <p><strong>Member Since:</strong> <?php echo $user['date_created']; ?></p>
        </div>
    </div>
</body>
</html>
