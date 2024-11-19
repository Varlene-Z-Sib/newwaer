<?php
session_start();
include 'DBConn.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ClothingID'])) {
    $clothingID = intval($_POST['ClothingID']);
    
    // Check if the item exists in the database
    $stmt = $conn->prepare("SELECT * FROM tblClothes WHERE ClothingID = ?");
    $stmt->bind_param("i", $clothingID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        if (!isset($_SESSION['cart'][$clothingID])) {
            $_SESSION['cart'][$clothingID] = array(
                'ClothingName' => $product['ClothingName'],
                'Price' => $product['Price'],
                'Quantity' => 1
            );
        } else {
            $_SESSION['cart'][$clothingID]['Quantity']++;
        }
    }
    $stmt->close();
}

// Handle updating quantity in the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $clothingID => $quantity) {
        if (isset($_SESSION['cart'][$clothingID])) {
            $_SESSION['cart'][$clothingID]['Quantity'] = max(1, intval($quantity));
        }
    }
}
//empty cart
if (isset($_GET['action']) && $_GET['action'] == 'empty') {
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Clears all items from the cart
    }
}

// Handle removing an item from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['ClothingID'])) {
    $clothingID = intval($_GET['ClothingID']);
    if (isset($_SESSION['cart'][$clothingID])) {
        unset($_SESSION['cart'][$clothingID]);
    }
}

// Handle checkout 
if (isset($_POST['checkout'])) {
    $orderNum = uniqid('ORD');  // Generate a unique order reference number
    $sessionId = session_id();  // Get the session ID
    $userID = $_SESSION['user_id'];  // Assuming the user ID is stored in session when logged in

    // Calculate total price
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $clothingID => $item) {
        $itemTotal = $item['Price'] * $item['Quantity'];
        $totalPrice += $itemTotal;
    }

    // Insert into tblOrders with UserID
    $stmt = $conn->prepare("INSERT INTO tblOrders (orderNum, TotalPrice, UserID) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sdi", $orderNum, $totalPrice, $userID);
        $stmt->execute();
        $stmt->close();
    } else {
        die("Error inserting order into tblOrders: " . $conn->error);
    }

    // Insert each cart item into the tblOrderLine table
    foreach ($_SESSION['cart'] as $clothingID => $item) {
        $quantity = $item['Quantity'];
        $stmt = $conn->prepare("INSERT INTO tblOrderLine (orderNum, ClothingID, Quantity, Price, sessionId) VALUES (?, ?, ?, ?,?)");
        if ($stmt) {
            $stmt->bind_param("siids", $orderNum, $clothingID, $quantity, $item['Price'], $sessionId);
            $stmt->execute();
            $stmt->close();
            
            // Update stock quantity in tblClothes
            $updateStockStmt = $conn->prepare("UPDATE tblClothes SET StockQuantity = StockQuantity - ? WHERE ClothingID = ?");
            if ($updateStockStmt) {
                $updateStockStmt->bind_param("ii", $quantity, $clothingID);
                $updateStockStmt->execute();
                $updateStockStmt->close();
            } else {
                die("Error updating stock: " . $conn->error);
            }
        } else {
            die("Error inserting order line into tblOrderLine: " . $conn->error);
        }
    }

    // Clear cart after checkout
    $_SESSION['cart'] = array();

    // Redirect to checkout_success.php with the order number and session ID as query parameters
    header("Location: checkout_success.php?orderNum={$orderNum}&sessionId={$sessionId}");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<script src="https://kit.fontawesome.com/2a688c5415.js" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!--<style>
        h1 {
            color: #00b0ff; /* Light blue for the title */
        }

        p {
            color: #0081c2; /* Darker blue for the "cart is empty" message */
        }
    
        input[type="submit"] {
            background-color: #00b0ff; /* Blue background */
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0081c2; /* Darker blue on hover */
        }
		
		
	


    </style>-->
</head>
<body>
<header>
   <header>
        <ul class="nav py-2">
			
			  <li class="nav-item item0">
				<a class="navbar-brand" href="index.php">
					<img src="_images/whitelogo.png" height="40" width="40" ></a></th>
				</a>
			  </li>
			  
			  
			  <li class="nav-item item1">
				  <a class="nav-link active" href="messages.php">
						<i class="fa-solid fa-message"></i>
				  </a>
			  </li>
			  
			  <li class="nav-item item2">
				  <a class="nav-link active" aria-current="page" href="#">
						<i class="fa-solid fa-cart-shopping"></i> Cart
				  </a>
			  </li>
				  
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="fa-solid fa-user"></i> User
				  </a>
				  <ul class="dropdown-menu">
					<li><a class="dropdown-item" href="logout.php">Logout</a></li>
					<li><a class="dropdown-item" href="order_history.php">Order History</a></li>
					<li><a class="dropdown-item" href="sellRequest.php">send request</a></li>						
				  </ul>
				</li>
			</ul>
			<hr>
       
    </header>
</header>

<div class="tablecontainer cart">
   

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <form method="post" action="cart.php">
            <table border="1">
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php
                $totalPrice = 0;
                foreach ($_SESSION['cart'] as $clothingID => $item):
                    $itemTotal = $item['Price'] * $item['Quantity'];
                    $totalPrice += $itemTotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['ClothingName']) ?></td>
                        <td>$<?= number_format($item['Price'], 2) ?></td>
                        <td>
                            <input type="number" name="quantity[<?= $clothingID ?>]" value="<?= $item['Quantity'] ?>" min="1">
                        </td>
                        <td>$<?= number_format($itemTotal, 2) ?></td>
                        <td><a href="cart.php?action=remove&ClothingID=<?= $clothingID ?>">Remove</a></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total Price</strong></td>
                    <td colspan="2"><strong>$<?= number_format($totalPrice, 2) ?></strong></td>
                </tr>
            </table>
            <input type="submit" name="update_cart" value="Update Cart">
            <input type="submit" name="checkout" value="Checkout">
			
			<a href="cart.php?action=empty" class="btn-empty-cart">Empty Cart</a>

        </form>
    <?php endif; ?>
</div>

<p><a href="index.php">Continue Shopping</a></p>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php $conn->close(); ?>
