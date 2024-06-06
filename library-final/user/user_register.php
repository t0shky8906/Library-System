<?php
    include "u_header.php";
    include "../conn.php";

    if (isset($_POST['submit'])) {
    // Retrieve form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $MI = $_POST['MI'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    
    // Check if username already exists
    $checkUsernameQuery = "SELECT username FROM user WHERE username = '$username'";
    $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);
    
    // Check if email already exists
    $checkEmailQuery = "SELECT email FROM user WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);
    
    if (mysqli_num_rows($checkUsernameResult) > 0) {
        // Username already exists
        echo '<div class="alert alert-danger" role="alert">Username already exists.</div>';
    } elseif ($password !== $cpassword) {
        // Passwords don't match
        echo '<div class="alert alert-danger" role="alert">Password and Confirm Password do not match.</div>';
    } elseif (mysqli_num_rows($checkEmailResult) > 0) {
        // Email already exists
        echo '<div class="alert alert-danger" role="alert">Email already exists.</div>';
    } else {
        // SQL insert statement
        $sql = "INSERT INTO user (firstname, lastname, MI, address, phone, email, username, password, date_created)
        VALUES ('$fname', '$lname', '$MI', '$address', '$phone', '$email', '$username', '$password', CURRENT_TIMESTAMP)";

        
        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo '<div class="alert alert-success" role="alert">Record inserted successfully.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . mysqli_error($conn) . '</div>';
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Online Library</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles */
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
            background: url("user_img/lib5.jpg");
            background-color: #fff;
            padding: 20px;
            padding-top: 0;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            opacity: 75%;
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

        /*-----------------error message----------------*/
        /*.error-message {
            color: red;
            font-weight: bold;
        }

        .success-message {
            color: green;
            font-weight: bold;
        }*/

    </style>
</head>
<body>
    <div>
        <section class="sec2">
            <div class="container">
                <br>
                <div class="box2">
                    <form method="post">
                        <h1>Page Turner Online Library Registration Form</h1>
                        <div class="form-group">
                            <input type="text" class="form-control" name="fname" placeholder="Enter your Firstname" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="lname" placeholder="Enter your Lastname" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="MI" placeholder="Enter your Middle Initial" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" placeholder="Enter your Address" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" placeholder="Enter your Phone Number" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Enter your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Enter your Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Enter your Password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="cpassword" placeholder="Confirm your Password" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Register" class="form-btn">
                        </div>
                    </form>              
                </div>
            </div>
        </section>
        <footer>
            <p class="foot">&copy; 2023 Library System</p>
        </footer>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
