<?php
session_start();
include 'DBConn.php';

// Check if the admin is logged in
if (!isset($_SESSION['Admin_ID'])) {
    header("Location: adminLogin.php");
    exit();
}

// Fetch sell requests with user details
$sql = "SELECT 
            tblSellRequests.request_id, 
            tblSellRequests.name AS request_name, 
            tblUser.UserName AS user_name, 
            tblSellRequests.price, 
            tblSellRequests.description, 
            tblSellRequests.brand, 
            tblSellRequests.image_path AS Image, 
            tblSellRequests.status 
        FROM tblSellRequests 
        INNER JOIN tblUser ON tblSellRequests.UserID = tblUser.UserID";

$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}

// Close the database connection
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Sell Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
        }

        header {
            background-color: #333;
            padding: 10px 0;
            text-align: center;
            color: white;
        }

        h2 {
            text-align: center;
            color: #00b0ff;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
			background-color: black;
			color: white;
        }

        table th {
            background-color: #00b0ff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table td img {
            width: 50px;
            height: auto;
        }

        select, input[type="submit"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #00b0ff;
            color: white;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background-color: #0081c2;
        }

        .back-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #00b0ff;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #0081c2;
        }

        #topLinks ul {
            display: flex;
            justify-content: center;
            padding: 0;
            list-style: none;
            background-color: #333;
        }

        #topLinks ul li {
            padding: 14px 20px;
        }

        #topLinks ul li a {
            color: white;
            text-decoration: none;
        }

        #topLinks ul li a:hover {
            background-color: #555;
        }

        .currentPage {
            background-color: #00b0ff;
        }

        .error-message {
            color: red;
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <nav id="topnav">
            <a href="index.php"><img src="_images/whitelogo.png" height="150" width="150" alt="Logo"></a>
        </nav>
        <nav id="topLinks">
            <ul>
                <li><a href="adminDashboard.php">Home</a></li>
                <li class="currentPage">View Sell Requests</li>
            </ul>
        </nav>
    </header>

    <main>
        

        <h2>Manage Sell Requests</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Request Name</th>
                    <th>User Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['request_name']) ?></td>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td>$<?= htmlspecialchars($row['price']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
                        <td><?= htmlspecialchars($row['brand']) ?></td>
                        <td><img src='_images/<?= htmlspecialchars($row['Image']) ?>' ></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td>
                            <form method="POST" action="processRequestAction.php">
                                <input type="hidden" name="requestID" value="<?= htmlspecialchars($row['request_id']) ?>" />
                                <select name="action">
                                    <option value="approve">Approve</option>
                                    <option value="reject">Reject</option>
                                    <option value="delete">Delete</option>
                                </select>
                                <input type="submit" value="Submit" />
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="error-message">No sell requests found.</p>
        <?php endif; ?>

        <!-- Back Button -->
        <a href="login.php" class="back-button">logout</a>
    </main>
</body>

</html>
