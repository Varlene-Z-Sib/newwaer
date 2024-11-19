<?php
session_start();
include 'DBConn.php';


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

// Fetch orders for the logged-in user
$stmt = $conn->prepare("SELECT * FROM tblOrders WHERE UserID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

// Calculate the total of all purchases
$totalPurchases = 0;
while ($row = $result->fetch_assoc()) {
    $totalPurchases += $row['TotalPrice'];
    $orders[] = $row; // Store each row to use later in HTML
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order History</title>
    <style>
        /* General Page Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #000; /* Black background */
            color: #1E90FF; /* Dodger blue text color */
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .connection-message {
            background-color: #1E90FF; /* Blue background */
            color: #000; /* Black text for contrast */
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .container {
            background-color: #1A1A1A; /* Dark gray for container */
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        /* Title Styling */
        .title {
            color: #1E90FF;
            margin-bottom: 1.5rem;
        }

        /* Order Table Styling */
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }

        .order-table th,
        .order-table td {
            padding: 0.75rem 1rem;
            border: 1px solid #1E90FF;
            color: #FFFFFF; /* White text for contrast */
        }

        .order-table th {
            background-color: #1E90FF; /* Blue headers */
            font-weight: bold;
            color: #000; /* Black text in headers */
        }

        .order-table tr:nth-child(even) {
            background-color: #2D2D2D; /* Darker gray for striped rows */
        }

        /* Total Purchase Amount Styling */
        .total-purchases {
            font-size: 1.2rem;
            color: #1E90FF;
            margin-top: 1rem;
            font-weight: bold;
        }

        /* No Orders Message Styling */
        .no-orders {
            color: #1E90FF;
            font-size: 1.2rem;
            margin-top: 1rem;
        }

        /* Link Styling */
        .back-link {
            color: #1E90FF;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            color: #00BFFF; /* Light blue on hover */
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php if (isset($connection_message)): ?>
        <div class="connection-message">
            <?= $connection_message ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <h1 class="title">Your Order History</h1>

        <?php if (!empty($orders)): ?>
            <table class="order-table">
                <tr>
                    <th>Order Number</th>
                    <th>Total Price</th>
                    <th>Date</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['orderNum']) ?></td>
                        <td>$<?= number_format($order['TotalPrice'], 2) ?></td>
                        <td><?= htmlspecialchars($order['OrderDate']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <p class="total-purchases">Total of All Purchases: $<?= number_format($totalPurchases, 2) ?></p>
        <?php else: ?>
            <p class="no-orders">You have no order history.</p>
        <?php endif; ?>

        <p><a href="index.php" class="back-link">Return to Home</a></p>
    </div>
</body>
</html>
