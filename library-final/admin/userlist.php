<?php
session_start();
include "../conn.php";
include "dash_header.php";

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

// Retrieve unique user information from the user table along with the total fine from the issued_books table
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$userQuery = "SELECT u.id, u.firstname, u.lastname, u.MI, u.address, u.phone, u.email, u.username, SUM(i.fine) AS total_fine
              FROM user u
              LEFT JOIN issued_books i ON u.username = i.user
              WHERE u.firstname LIKE '%$searchKeyword%' OR u.lastname LIKE '%$searchKeyword%' OR u.username LIKE '%$searchKeyword%'
              GROUP BY u.id
              ORDER BY u.id";
$userResult = mysqli_query($conn, $userQuery);

if (!$userResult) {
    $errorMessage = "Failed to retrieve user information: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles */
        *{
            font-family: Arial, sans-serif;
        }   
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: lightblue;
            color: #333;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-input {
            padding: 5px;
            width: 200px;
        }

        .view-btn {
            padding: 5px 10px;
            background-color: #17a2b8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .fine-btn {
            padding: 5px 10px;
            background-color: #17a2b8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>User List</h1>

        <?php if (isset($errorMessage)) { ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php } ?>

        <form class="search-form" method="GET">
            <input class="search-input" type="text" name="search" placeholder="Search by name or username" value="<?php echo $searchKeyword; ?>">
            <button class="search-button" type="submit">Search</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>MI</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Total Fine</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($userResult)) { ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['firstname']; ?></td>
                        <td><?php echo $user['lastname']; ?></td>
                        <td><?php echo $user['MI']; ?></td>
                        <td><?php echo $user['address']; ?></td>
                        <td><?php echo $user['phone']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['total_fine']; ?></td>
                        <td>
                            <a href="vubb.php?id=<?php echo $user['id']; ?>" class="view-btn">View</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
