<?php
	include "header.php";
	session_start();
?>

<html>
    <head>
        <title>Online Library</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="index">
            <section>
                <br>
            <div class="box">
                <h1>Welcome to the Page Turner Online Library System</h1>
                <h2>Our library system offers a wide range of Books, Articles, Magazines,
                     Journals for all ages and interests. Search for books, check availability,
                      reserve and borrow them for just a few clicks.</h2>              
            </div>
            <div class="indexbtn">
            	<a class="btn btn-primary" href="user/user_login.php">LOGIN</a>
            	<a class="btn btn-primary" href="user/user_register.php">REGISTER</a>
            </div>
            </section>
            <hr>
            <footer>
                <p class="foot">&copy; 2023 Library System</p>
            </footer>
        </div>
    </body>
</html>