<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}

include "../conn.php";
include "dash_header.php";

$errorMessage = "";

// Update personal information
if (isset($_POST['update'])) {
    $username = $_SESSION['username'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $adminemail = $_POST['adminemail'];

    $updateQuery = "UPDATE admin SET firstname='$firstname', middlename='$middlename', lastname='$lastname', adminemail='$adminemail' WHERE username='$username'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        $successMessage = "Personal information updated successfully.";
    } else {
        $errorMessage = "Failed to update personal information: " . mysqli_error($conn);
    }
}

// Change password
if (isset($_POST['changePassword'])) {
    $username = $_SESSION['username'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Retrieve current password from the database
    $passwordQuery = "SELECT password FROM admin WHERE username='$username'";
    $passwordResult = mysqli_query($conn, $passwordQuery);
    $row = mysqli_fetch_assoc($passwordResult);
    $currentPasswordDB = $row['password'];

    // Verify current password
    if ($currentPassword == $currentPasswordDB) {
        // Check if new password and confirm password match
        if ($newPassword == $confirmPassword) {
            // Update the password in the database
            $updatePasswordQuery = "UPDATE admin SET password='$newPassword' WHERE username='$username'";
            $updatePasswordResult = mysqli_query($conn, $updatePasswordQuery);

            if ($updatePasswordResult) {
                $successMessage = "Password changed successfully.";
            } else {
                $errorMessage = "Failed to change password: " . mysqli_error($conn);
            }
        } else {
            $errorMessage = "New password and confirm password do not match.";
        }
    } else {
        $errorMessage = "Incorrect current password.";
    }
}

// Retrieve admin information
$username = $_SESSION['username'];
$adminQuery = "SELECT * FROM admin WHERE username='$username'";
$adminResult = mysqli_query($conn, $adminQuery);
$admin = mysqli_fetch_assoc($adminResult);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles for the admin profile page */
        /* ... */
        /* Custom styles for the admin profile page */
        *{
            font-family: Arial, sans-serif;
        }

        .container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f2f2f2;
        border-radius: 5px;
        }

        h1 {
        text-align: center;
        margin-bottom: 20px;
        }

        form {
        margin-bottom: 20px;
        }

        label {
        display: block;
        margin-bottom: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        }

        button[type="submit"] {
        display: block;
        width: 100%;
        padding: 10px;
        background-color:#007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        }

        .error-message {
        color: #ff0000;
        margin-bottom: 10px;
        }

        .success-message {
        color: #008000;
        margin-bottom: 10px;
        }


    </style>
</head>
<body>
    <!-- Admin Profile Page HTML code -->
    <div class="container">
        <h1>Admin Profile</h1>

        <?php if (isset($errorMessage)) { ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php } ?>

        <?php if (isset($successMessage)) { ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php } ?>

        <form method="post" action="">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php echo $admin['firstname']; ?>" required>

            <label for="middlename">Middle Name:</label>
            <input type="text" id="middlename" name="middlename" value="<?php echo $admin['middlename']; ?>">

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo $admin['lastname']; ?>" required>

            <label for="adminemail">Email:</label>
            <input type="email" id="adminemail" name="adminemail" value="<?php echo $admin['adminemail']; ?>" required>

            <button type="submit" name="update">Update Personal Information</button>
        </form>

        <hr>

        <form method="post" action="">
            <h2>Change Password</h2>

            <label for="currentPassword">Current Password:</label>
            <input type="password" id="currentPassword" name="currentPassword" required>

            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <button type="submit" name="changePassword">Change Password</button>
        </form>
    </div>
</body>
</html>
