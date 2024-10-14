<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>admin page</title>
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
					<li class="currentPage">Home</a></li>
				</ul>
			</nav>
		</div>
			
			<div id="banner">
				<img src="_images/homepage.png" id="l_Logo" height="300">
			</div>
    </header>
	
	<div class="container">

		<?php
		session_start();
		include 'DBConn.php'; // Include the connection file

		// Fetch products from tblClothes
		$sql = "SELECT * FROM tblClothes";
		$result = $conn->query($sql);
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Clothing Store - Homepage</title>
		</head>
		<body>
		<div class="tablecontainer">
		<h1>Welcome to Our Clothing Store</h1>
		"<a href='logout.php'>Logout</a>";

		<table border="1" class="table">
			<tr>
				<th>Image</th>
				<th>Product Name</th>
				<th>Category</th>
				<th>Price</th>
				<th>Stock</th>
				<th>Add to Cart</th>
			</tr>
			<?php
			if ($result->num_rows > 0) {
				// Display products
				while($row = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td><img src='".$row['ProductImage']."' alt='".$row['ClothingName']."' width='100'></td>";
					echo "<td>".$row['ClothingName']."</td>";
					echo "<td>".$row['Category']."</td>";
					echo "<td>$".$row['Price']."</td>";
					echo "<td>".$row['StockQuantity']."</td>";
					echo "<td>
							<form action='cart.php' method='post'>
								<input type='hidden' name='ClothingID' value='".$row['ClothingID']."'>
								<input type='submit' value='Add to Cart'>
							</form>
						</td>";
					echo "</tr>";
				}
			} else {
				echo "<tr><td colspan='6'>No products available</td></tr>";
			}
			?>
		</table>
		</div>
		</body>
		</html>
		<?php
		$conn->close();
		?>
	</div>
   </body>
</html>
		