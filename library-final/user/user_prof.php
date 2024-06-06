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

// Handle form submission for updating personal information
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $mi = $_POST['mi'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $dateUpdated = date('Y-m-d H:i:s');

    // Validate required fields
    $requiredFields = ['firstname', 'lastname', 'address', 'phone', 'email'];
    $errors = [];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst($field) . ' is required.';
        }
    }

    if (empty($errors)) {
        // Update user information in the database
        $updateQuery = "UPDATE user SET firstname = '$firstname', lastname = '$lastname', MI = '$mi', address = '$address', phone = '$phone', email = '$email', date_updated = '$dateUpdated' WHERE username = '$username'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            $successMessage = "Personal information updated successfully!";
            $user['firstname'] = $firstname;
            $user['lastname'] = $lastname;
            $user['MI'] = $mi;
            $user['address'] = $address;
            $user['phone'] = $phone;
            $user['email'] = $email;
        } else {
            $errorMessage = "Failed to update personal information. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles for the user profile page */

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
            background-color: #f8d7da;
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
        <h1>User Profile</h1>

        <?php if (isset($successMessage)) { ?>
            <div class="alert alert-success" role="alert"><?php echo $successMessage; ?></div>
        <?php } ?>

        <?php if (isset($errorMessage)) { ?>
            <div class="alert alert-danger" role="alert"><?php echo $errorMessage ?></div>
        <?php } ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>" required>
            </div>
            <div class="form-group">
                <label for="mi">Middle Initial:</label>
                <input type="text" id="mi" name="mi" value="<?php echo $user['MI']; ?>">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $user['address']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="form-group" style="width: 103%;">
                <input type="submit" name="update_info" value="Update Personal Information" class="form-btn">
            </div>
        </form>

        <form method="post" action="change_pass.php" style="width: 103%;">
            <div class="form-group">
                <input type="submit" name="change_pass" value="Change Password" class="form-btn">
            </div>
        </form>
        <?php if (!empty($errors)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($errors as $error) {
                    echo $error . "<br>";
                } ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>
