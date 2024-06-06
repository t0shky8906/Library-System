<?php
session_start();
ob_start(); // Start output buffering
include "../conn.php";
include "dash_header.php";

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
    exit();
}

$pendingRequestsQuery = "SELECT * FROM pending_book_requests WHERE request_status != 'Rejected'";
$pendingRequestsResult = mysqli_query($conn, $pendingRequestsQuery);

if (!$pendingRequestsResult) {
    $errorMessage = "Failed to retrieve pending requests: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approve Requests</title>
    <!-- Include CSS styles here -->
    <style>
        /* Custom styles */
        *{
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .request-card {
            display: inline-block;
            width: 200px;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }

        .request-card h4 {
            margin-bottom: 5px;
        }

        .request-card p {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .approve-btn {
            padding: 10px 20px;
            font-size: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .approve-btn:hover {
            background-color: darkblue;
        }

        .reject-btn {
            padding: 10px 20px;
            font-size: 12px;
            background-color: red;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .reject-btn:hover {
            background-color: darkred;
        }

        .message {
            margin-top: 20px;
            color: green;
        }

        .error-message {
            margin-top: 20px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Approve Requests</h1>

        <?php if (isset($errorMessage)) { ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php } ?>

        <?php while ($request = mysqli_fetch_assoc($pendingRequestsResult)) { ?>
            <div class="request-card">
                <h4>Request ID: <?php echo $request['br_id']; ?></h4>
                <p>User: <?php echo $request['user']; ?></p>
                <p>Book ISBN: <?php echo $request['book_isbn']; ?></p>
                <p>Request Time: <?php echo $request['time']; ?></p>
                <form method="post" action="">
                    <input type="hidden" name="request_id" value="<?php echo $request['br_id']; ?>">
                    <input type="submit" name="approve" value="Approve" class="approve-btn">
                    <input type="submit" name="reject" value="Reject" class="reject-btn">
                </form>

            </div>
        <?php } ?>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['approve'])) {
                $requestId = $_POST['request_id'];

                $requestQuery = "SELECT * FROM pending_book_requests WHERE br_id = $requestId";
                $requestResult = mysqli_query($conn, $requestQuery);
                $request = mysqli_fetch_assoc($requestResult);

                $insertQuery = "INSERT INTO issued_books (user, book_isbn, requestTime, dateApproved, returnDate, returnStatus) VALUES ('$request[user]', '$request[book_isbn]', '$request[time]', NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY), 'Not yet returned')";
                $insertResult = mysqli_query($conn, $insertQuery);

                if ($insertResult) {
                    $deleteQuery = "DELETE FROM pending_book_requests WHERE br_id = $requestId";
                    $deleteResult = mysqli_query($conn, $deleteQuery);

                    if ($deleteResult) {
                        ob_end_clean(); // Clean the output buffer
                        header("Location: approverequest.php");
                        exit(); // Terminate the script
                    } else {
                        echo '<div class="error-message">Failed to delete the approved request from pending_book_requests table.</div>';
                    }
                } else {
                    echo '<div class="error-message">Failed to insert the approved request into issued_books table.</div>';
                }
            } elseif (isset($_POST['reject'])) {
                $requestId = $_POST['request_id'];

                $deleteQuery = "DELETE FROM pending_book_requests WHERE br_id = $requestId";
                $deleteResult = mysqli_query($conn, $deleteQuery);

                if ($deleteResult) {
                    ob_end_clean(); // Clean the output buffer
                    header("Location: approverequest.php");
                    exit(); // Terminate the script
                } else {
                    echo '<div class="error-message">Failed to delete the rejected request from pending_book_requests table.</div>';
                }
            }
        }
        ?>
    </div>
</body>
</html>
