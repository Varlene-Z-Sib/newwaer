<?php
session_start();
include 'DBConn.php'; // Include the connection file

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

        // Check if the item is already in the cart
        if (!isset($_SESSION['cart'][$clothingID])) {
            // Add item to cart with quantity 1
            $_SESSION['cart'][$clothingID] = array(
                'ClothingName' => $product['ClothingName'],
                'Price' => $product['Price'],
                'Quantity' => 1
            );
        } else {
            // Increment quantity if item is already in the cart
            $_SESSION['cart'][$clothingID]['Quantity']++;
        }
    }

    $stmt->close();
}

// Handle removing an item from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['ClothingID'])) {
    $clothingID = intval($_GET['ClothingID']);
    if (isset($_SESSION['cart'][$clothingID])) {
        unset($_SESSION['cart'][$clothingID]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
  
	<header>
	  <div class="box nav-box1">
			<nav id="topnav">
				<th> <a href="index.php"><img src="_images/whitelogo.png" height="150" width="150" alt="Logo"></a></th>
				<div class="search">
					<form action="#">
						<input type="text" placeholder="Search..." name="search">
						<button><i class="fa fa-search">search</i></button>
					</form>
				</div>
			</nav>
	  </div>			
	  <div class="box nav-box2">
			<nav id="topLinks">
				<ul>
					<li><a href="">Women</a></li>
					<li><a href="">Men</a></li>
					<li><a href="">Kids</a></li>
					<li><a href="">Shoes</a></li>
					<li><a href="">Acesories</a></li>
					<li><a href="">Vintage</a></li>
					<li><a href="">Sale</a></li>					
					<li><a href="index.php">Home</a></li>
				</ul>
			</nav>
		</div>
			
			<div id="banner">
				<img src="_images/homepage.png" id="l_Logo" height="300">
			</div>
    </header>
	
	<div class="tablecontainer ">
		<h1>Your Shopping Cart</h1>

		<?php
		if (empty($_SESSION['cart'])) {
			echo "<p>Your cart is empty.</p>";
		} else {
			echo "<table border='1'>
					<tr>
						<th>Product Name</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total</th>
						<th>Action</th>
					</tr>";
			$totalPrice = 0;
			foreach ($_SESSION['cart'] as $clothingID => $item) {
				$itemTotal = $item['Price'] * $item['Quantity'];
				$totalPrice += $itemTotal;

				echo "<tr>
						<td>{$item['ClothingName']}</td>
						<td>\${$item['Price']}</td>
						<td>{$item['Quantity']}</td>
						<td>\${$itemTotal}</td>
						<td><a href='cart.php?action=remove&ClothingID={$clothingID}'>Remove</a></td>
					  </tr>";
			}
			echo "<tr>
					<td colspan='3'><strong>Total Price</strong></td>
					<td colspan='2'><strong>\$$totalPrice</strong></td>
				  </tr>";
			echo "</table>";
		}
		?>
	</div>

<p><a href="index.ph	p">Continue Shopping</a></p>

</body>
</html>
<?php
$conn->close();
?>

