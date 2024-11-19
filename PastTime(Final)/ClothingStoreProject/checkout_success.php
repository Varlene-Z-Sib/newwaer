<?php
// Start session to access session variables
session_start();

// Get orderNum and sessionId from the query parameters
$orderNum = isset($_GET['orderNum']) ? $_GET['orderNum'] : '';
$sessionId = isset($_GET['sessionId']) ? $_GET['sessionId'] : '';

// If orderNum or sessionId is not provided, redirect to the cart page
if (empty($orderNum) || empty($sessionId)) {
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Success</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
    <!-- Redirect to login page after 10 seconds -->
    <meta http-equiv="refresh" content="10;url=login.php">
    
    <!-- Optional: Add JavaScript-based redirection -->
    <script type="text/javascript">
        setTimeout(function() {
            window.location.href = "login.php"; // Redirect to login page
        }, 10000); // 10000ms = 10 seconds
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000; /* Black background */
            color: #fff; /* White text color for contrast */
            text-align: center;
            padding: 50px;
        }

        .checkout-success {
            background-color: #001f3d; /* Dark blue background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Light shadow to add depth */
            max-width: 500px;
            margin: 0 auto;
        }

        h1 {
            color: #00b0ff; /* Light blue for the success message */
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .checkout-success p strong {
            color: #fff; /* White color for the important text */
            font-weight: bold;
        }

        /* Optional: Add a text shadow to make text more legible on backgrounds */
        h1, p {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        /* Style for the redirect message */
        .redirect-msg {
            font-size: 1.1em;
            margin-top: 20px;
            color: #ccc; /* Light grey color for the info message */
        }

        /* Adding a smooth transition for the background color */
        .checkout-success {
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>

<header>
    <!-- Header Content (Navigation, etc.) -->
</header>

<div class="checkout-success">
    <h1>Checkout Successful!</h1>
    <p>Thank you for your order. Your purchase has been completed successfully.</p>
    <p><strong>Order Number:</strong> <?= htmlspecialchars($orderNum) ?></p>
    <p><strong>Session ID:</strong> <?= htmlspecialchars($sessionId) ?></p>
    <p>You can expect an email confirmation shortly. Please note your order reference for future inquiries.</p>

    <div class="redirect-msg">
        <p>You will be redirected to the login page shortly...</p>
    </div>
</div>

</body>
</html>
