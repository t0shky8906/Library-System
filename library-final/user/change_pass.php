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

// Handle form submission for changing password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_pass'])) {
    if (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // Retrieve user information from the database
        $username = $_SESSION['username'];
        $query = "SELECT password FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        // Verify the current password
        if ($currentPassword === $user['password']) {
            // Validate the new password and confirm password
            if ($newPassword !== $confirmPassword) {
                $errorMessage = "New password and confirm password do not match. Please try again.";
            } else {
                // Update the password in the database
                $updateQuery = "UPDATE user SET password = '$newPassword' WHERE username = '$username'";
                $updateResult = mysqli_query($conn, $updateQuery);

                if ($updateResult) {
                    $successMessage = "Password changed successfully!";
                } else {
                    $errorMessage = "Failed to change the password. Please try again.";
                }
            }
        } else {
            $errorMessage = "Incorrect current password. Please try again.";
        }
    } else {
    }
}
?>

<!-- Rest of the HTML code remains the same -->


<!-- Rest of the HTML code remains the same -->


<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles for the change password page */
        *{
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input {
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

        .alert-success {
            color: black;
            font-weight: bold;
            background-color: #46d141;
            border-color: #46d141;
        }

        .alert-danger {
            color: black;
            font-weight: bold;
            background-color: #ff4b5c;
            border-color: #f5c6cb;
        }

        .alert {
            position: relative;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            align-items: center;
            width: 98%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Change Password</h1>

        <?php if (isset($successMessage)) { ?>
            <div class="alert alert-success" role="alert"><?php echo $successMessage; ?></div>
        <?php } ?>

        <?php if (isset($errorMessage)) { ?>
            <div class="alert alert-danger" role="alert"><?php echo $errorMessage; ?></div>
        <?php } ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group" style="width: 103%;">
                <input type="submit" name="change_pass" value="Change Password" class="form-btn">
            </div>
        </form>
    </div>
</body>
</html>
