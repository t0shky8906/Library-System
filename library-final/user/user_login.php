<?php
session_start(); // Start the session
include "u_header.php";
include "../conn.php";

if (isset($_POST['login'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to check if the username and password match
    $loginQuery = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $loginResult = mysqli_query($conn, $loginQuery);

    if (mysqli_num_rows($loginResult) > 0) {
        // Login successful
        $_SESSION['username'] = $username;
        header("Location: user_dash.php");
        exit();
    } else {
        // Login failed
        $loginError = "Invalid username or password.";
    }
}
?>
<!-- HTML code for the login form -->
<!DOCTYPE html>
<html>
<head>
    <title>Online Library - Login</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles */
        /* Copy the CSS styles from the registration form and paste them here */
        /* ... */
        body {
            background-color: #f7f7f7;
        }

        h1 {
            color: white;
            margin-bottom: 0;
            font-size: 24px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            display: inline;
            margin-left: 10px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        .sec2 {
            height:83vh;
            background: url("user_img/lib5.jpg");
            background-color: #fff;
            padding: 20px;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            opacity: 75%;
            padding-top: 80px;
        }

        .box2 {
            width: 400px;
            margin: 0 auto;
            background-color: black;
            opacity: 90%;
            padding: 20px;
            border-radius: 5px;
        }

        .box2 h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .form-btn {
            width: 100%;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            background-color: blue;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        .form-btn:hover {
            background-color: #23272b;
        }

        footer{
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- HTML code for the login form -->
    <div class="body">
        <section class="sec2">
            <!-- Copy the container, box, and form code from the registration form and paste them here -->
            <!-- Update the form action to an empty action attribute -->
            <div class="container">
                <div class="box2">
                    <form method="post" action="">
                        <h1>Page Turner Online Library Login Form</h1>
                        <?php if (isset($loginError)) { ?>
                            <div class="alert alert-danger" role="alert"><?php echo $loginError; ?></div>
                        <?php } ?>
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Enter your Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Enter your Password" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="login" value="Login" class="form-btn">
                        </div>
                    </form>
                </div>
            </div>
        </section>
            <footer>
                <p class="foot">&copy; 2023 Library System</p>
            </footer>
    </div>
</body>
</html>
