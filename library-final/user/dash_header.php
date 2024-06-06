<!DOCTYPE html>
<html>
<head>
    <title>Library System - User Dashboard</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles for the user dashboard header */

        .head header {
            background-color:skyblue;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .head header nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .head header nav ul li {
            margin-right: 20px;
        }

        .head header nav ul li a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            padding: 10px;
        }

        .head header nav ul li a:hover {
            background-color: #333;
            color: white;
            border-radius: 4px;
        }
    </style>
</head>
<div class="head">
<body>
    <!-- User Dashboard Header -->
    <header>
        <nav>
            <ul>
                <li><a href="user_dash.php">Dashboard</a></li>
                <li><a href="user_prof.php">Profile</a></li>
                <li><a href="borrow_book.php">Books</a></li>
                <li><a href="mybooks.php">My Books</a></li>
                <li><a href="user_logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <!-- End of User Dashboard Header -->

    <!-- Include the rest of the user dashboard content below -->
    <!-- ... -->
</div>
</body>
</html>
