<!DOCTYPE html>
<html>
<head>
    <title>Library System - User Dashboard</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles for the user dashboard header */

        .head header {
            border-radius: 10px;
            background-color: lightblue;
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
            color: #333;
            font-weight: bold;
            padding: 10px;
        }

        .head header nav ul li a:hover {
            background-color: #333;
            color: #fff;
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
                <li><a href="admin_dash.php">Dashboard</a></li>
                <li><a href="admin_prof.php">Profile</a></li>
                <li><a href="booklist.php">List of Books</a></li>
                <li><a href="addbooks.php">Add Books</a></li>
                <li><a href="approverequest.php">Borrow Requests</a></li>
                <li><a href="issuedbooks.php">Issued Books</a></li>
                <li><a href="userlist.php">Users</a></li>
                <li><a href="admin_logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <!-- End of User Dashboard Header -->

    <!-- Include the rest of the user dashboard content below -->
    <!-- ... -->

</body>
</div>
</html>
