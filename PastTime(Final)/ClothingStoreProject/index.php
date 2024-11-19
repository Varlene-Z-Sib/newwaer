<!doctype html>  
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HomePage</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<script src="https://kit.fontawesome.com/2a688c5415.js" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" type="text/css" href="css/style.css">
	
	<script>
	  const categoryButtons = document.querySelectorAll('.nav-link[data-category]');

	  categoryButtons.forEach(button => {
		button.addEventListener('click', (event) => {
		  const category = event.target.dataset.category;
		  
		  // Update the URL with the selected category (optional)
		  window.location.href = `index.php?category=${category}`;
		});
	  });
	  
	  p{
		  color: white;
	  }
	  
	  .mission-statement {
		  text-align: center;
		  background: blue;
		}

		.mission-title {
		  font-size: 24px; /* Adjust font size as needed */
		  font-weight: bold;
		  margin-bottom: 20px;
		}

		.mission-text {
		  font-size: 18px; /* Adjust font size as needed */
		  line-height: 1.5;
		  margin-bottom: 20px;
		}
		
		.mission-title, .mission-text {
		  color: white;
		}
	  
	</script>

</head>
<body>

	<?php
        session_start();
        include 'DBConn.php';
        
        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php?error=Please log in to complete your purchase.");
            exit();
        }

        // Handle category filter
        $categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
        ?>
	
    <header>
        <ul class="nav py-2">
			
			  <li class="nav-item item0">
				<a class="navbar-brand" href="index.php">
					<img src="_images/whitelogo.png" height="40" width="40" ></a></th>
				</a>
			  </li>
			  
			  <li class="nav-item item">
				  <form class="d-flex" role="search">
						<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-primary " type="submit">Search</button>
				  </form>
				</li>
			  
			  
			  <li class="nav-item item1">
				  <a class="nav-link active" aria-current="page" href="messages.php">
						<i class="fa-solid fa-message"></i>
				  </a>
			  </li>
			  
			  <li class="nav-item item2">
				  <a class="nav-link active" aria-current="page" href="cart.php">
						<i class="fa-solid fa-cart-shopping"></i> Cart
				  </a>
			  </li>
				  
				<li class="nav-item dropdown item3">
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
			
			<nav class="navbar navbar-expand-lg bg-body-tertiary">
			  <div class="container-fluid">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-around " id="">
				  <div class="navbar-nav">
					<a class="nav-link" href="index.php" data-category="All Categories">Home</a>
					<a class="nav-link" href="index.php?category=Women" data-category="Women">Women</a>
					<a class="nav-link" href="index.php?category=Men" data-category="Men">Men</a>
					<a class="nav-link" href="index.php?category=Kids" data-category="Kids">Kids</a>					
					<a class="nav-link" href="index.php?category=Shoes" data-category="Shoes">Shoes</a>
					<a class="nav-link" href="index.php?category=Accessories" data-category="Accessories">Accessories</a>
					<a class="nav-link" href="index.php?category=Vintage" data-category="Vintage">Vintage</a>
				  </div>
				</div>
			  </div>
			</nav>
		
		<div id="banner">
			<img src="_images/homepage.png" class="b_Logo">
			
			<div class="mission-statement">
	  <h2 class="mission-title">Our mission at Pastimes</h2>
	  <p class="mission-text">To provide a sustainable and stylish solution for pre-loved fashion, offering high-quality, authenticated clothing at affordable prices.</p>
	  <p class="mission-text">We're committed to reducing fashion waste and promoting conscious consumerism.</p>
	</div>
		</div>
		
    </header>
	
	

    <div class="container">
        

        
            <h1></h1>
			
            <!-- Filter Form --> <!--
            <form action="index.php" method="get">
                <label for="category">Filter by Category:</label>
                <select name="category" id="category">
                    <option value="">All Categories</option>
                    <option value="Women" <?php if($categoryFilter == "Women") echo "selected"; ?>>Women</option>
                    <option value="Men" <?php if($categoryFilter == "Men") echo "selected"; ?>>Men</option>
                    <option value="Kids" <?php if($categoryFilter == "Kids") echo "selected"; ?>>Kids</option>
                    <option value="Shoes" <?php if($categoryFilter == "Shoes") echo "selected"; ?>>Shoes</option>
                    <option value="Accessories" <?php if($categoryFilter == "Accessories") echo "selected"; ?>>Accessories</option>
                    <option value="Vintage" <?php if($categoryFilter == "Vintage") echo "selected"; ?>>Vintage</option>
                    
                </select>
                <button type="submit">Filter</button>
            </form>	-->
			
			<div class="tablecontainer">
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
                // Prepare the SQL query based on selected category
				
                if ($categoryFilter) {
                    $sql = "SELECT * FROM tblClothes WHERE Category = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $categoryFilter);
                } else {
                    $sql = "SELECT * FROM tblClothes";
                    $stmt = $conn->prepare($sql);
                }
                $stmt->execute();
                $result = $stmt->get_result();

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
    </div>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
