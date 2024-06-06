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
$query = "SELECT * FROM admin WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        .logo i{
            margin:10px;
        }
    </style>
</head>
<hr>
<body>
    <div class="container">
        <h1>Welcome to the Page - Turner Library Dashboard, <?php echo $admin['firstname']; ?>!</h1>

            <div class="user-info"> 
            <h2>User Information</h2>
            <p><strong>Username:</strong> <?php echo $admin['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $admin['adminemail']; ?></p>
            <p><strong>Full Name:</strong> <?php echo $admin['firstname'] . ' ' . $admin['middlename'] . ' ' . $admin['lastname']; ?></p>

        </div>
    </div>
    <!-- <div clas="logo">
        <h1>List of Book</h1>
        <i class="fa fa-book" style="font-size:48px;color:green"></i>
        <i class="fa fa-recycle fa-5x" style="font-size:48px;color:"></i>
        <i class="fa fa-user fa-5x" style="font-size:48px;color:"></i>
        <i class="fa fa-users fa-5x" style="font-size:48px;color:"></i>
    </div> -->
</body>
</html>
