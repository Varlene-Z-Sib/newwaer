<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<script src="https://kit.fontawesome.com/2a688c5415.js" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" type="text/css" href="css/style.css">

  <style>
    /* Styling for form inputs */
    input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="file"] {
      width: 100%;
      padding: 8px;
      margin: 5px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    /* Styling for form buttons */
    input[type="submit"] {
      background-color: #00b0ff; /* Blue background */
      color: white;
      font-size: 16px;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-top: 10px;
    }

    input[type="submit"]:hover {
      background-color: #0081c2; /* Darker blue on hover */
    }

    /* Styling for form containers */
    #addUserForm, #addClothingForm {
      background-color: #f4f4f4;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      width: 300px;
      margin: 20px auto;
    }
	
	th {
		  color: Blue;
		  padding: 8px;
		  text-align: center;
		}

    /* Heading styles */
    h3 {
      text-align: center;
      font-size: 24px;
      color: white;
    }

    /* Styling for labels */
    label {
      font-size: 14px;
      color: #333;
      margin-bottom: 5px;
      display: inline-block;
    }
	
	table{
		background: black;
		color: white;
	}
	
	.table-container{
		width: 103%;
		margin-left: 50px;
		
	
	
  </style>
</head>

<body>
	 <?php
		session_start();
		include 'DBConn.php';

		// Check if the admin is logged in
		if (!isset($_SESSION['Admin_ID'])) {
		  header("Location: adminLogin.php");
		  exit();
		} ?>

  <header>
    <ul class="nav py-2">
			
			  <li class="nav-item item0">
				<a class="navbar-brand" href="adminDashboard.php">
					<img src="_images/whitelogo.png" height="40" width="40" ></a></th>
				</a>
			  </li>
			  
			  
			  <li class="nav-item item1">
				  <a class="nav-link" aria-current="page" href="messages.php">
						<i class="fa-solid fa-message"></i>
				  </a>
			  </li>
			  
			  <li class="nav-item item2">
				  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="fa-solid fa-user"></i> Admin
				  </a>
				  <ul class="dropdown-menu">
					<li><a class="dropdown-item" href="logout.php">Logout  </a></li>
					<li><a class="dropdown-item" href="viewRequests.php" >View Sell Requests</a></li>		
				  </ul>
				</li>
			</ul>
		
		<div id="banner">
			<img src="_images/homepage.png" class="b_Logo">
		</div>
  </header>

  <main>
		<?php
		echo "<h3>Welcome, Admin: " . htmlspecialchars($_SESSION['Admin_ID']) . "</h3>"; ?>
		<br><hr>
		
		<div class="table-container">
		<?php
			// Display User List
			echo "<h3>User List</h3>";
			echo "<button onclick=\"document.getElementById('addUserForm').style.display='block'\" >Add User</button>";
			$sql = "SELECT UserID, UserName, Email, status FROM tblUser";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			  echo "<table border='1'>
					  <tr>
						  <th>UserID</th>
						  <th>UserName</th>
						  <th>Email</th>
						  <th>Verified</th>
						  <th>Actions</th>
					  </tr>";

			  while ($row = $result->fetch_assoc()) {
				echo "<tr>
						<td>" . htmlspecialchars($row['UserID']) . "</td>
						<td>" . htmlspecialchars($row['UserName']) . "</td>
						<td>" . htmlspecialchars($row['Email']) . "</td>
						<td>" . ($row['status'] ? 'Yes' : 'No') . "</td>
						<td>
						  <form method='POST' action='adminActions.php'>
							<input type='hidden' name='userID' value='" . htmlspecialchars($row['UserID']) . "' />
							<select name='action'>
							  <option value='verifyUser'>Verify</option>
							  <option value='deleteUser'>Delete</option>
							  <option value='updateUser'>Update</option>
							</select>
							<input type='submit' value='Submit' />
						  </form>
						</td>
					  </tr>";
			  }
			  echo "</table>";
			} else {
			  echo "No users found.";
			}?>
		</div>
		
			<br><hr>
			<!-- Display Clothing List-->
			<?php echo "<h3>Clothing List</h3>" ?>
		<div class="table-container">
		<?php	echo "<button onclick=\"document.getElementById('addClothingForm').style.display='block'\">Add Clothing</button>";
			$sql = "SELECT * FROM tblClothes";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			  echo "<table border='1'>
					  <tr>
						  <th>ClothingID</th>
						  <th>ClothingName</th>
						  <th>Category</th>
						  <th>Price</th>
						  <th>Stock Quantity</th>
						  <th>Product Image</th>
						  <th>Actions</th>
					  </tr>";

			  while ($row = $result->fetch_assoc()) {
				echo "<tr>
						<td>" . htmlspecialchars($row['ClothingID']) . "</td>
						<td>" . htmlspecialchars($row['ClothingName']) . "</td>
						<td>" . htmlspecialchars($row['Category']) . "</td>
						<td>" . htmlspecialchars($row['Price']) . "</td>
						<td>" . htmlspecialchars($row['StockQuantity']) . "</td>
						<td><img src='" . htmlspecialchars($row['ProductImage']) . "' height='50'></td>
						<td>
						  <form method='POST' action='adminActions.php' enctype='multipart/form-data'>
							<input type='hidden' name='clothingID' value='" . htmlspecialchars($row['ClothingID']) . "' />
							<select name='action'>
							  <option value='deleteClothing'>Delete</option>
							  <option value='updateClothing'>Update</option>
							</select>

							<input type='submit' value='Submit' />
						  </form>
						</td>
					  </tr>";
			  }
			  echo "</table>";
			} else {
			  echo "No clothing items found.";
			}
			?>
		</div>
		
		<br><hr>
		
  </main>
  
    <!-- Add User Form -->
    <div id="addUserForm" style="display:none;">
      <h3>Add New User</h3>
      <form method="POST" action="adminActions.php">
        <input type="hidden" name="action" value="addUser">
        <label>Username: <input type="text" name="userName" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <input type="submit" value="Add User">
      </form>
    </div>

    <!-- Add Clothing Form -->
    <div id="addClothingForm" style="display:none;">
      <h3>Add New Clothing</h3>
      <form method="POST" action="adminActions.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="addClothing">
        <label>Clothing Name: <input type="text" name="clothingName" required></label><br>
        <label>Category: <input type="text" name="category" required></label><br>
        <label>Price: <input type="number" step="0.01" name="price" required></label><br>
        <label>Stock Quantity: <input type="number" name="stockQuantity" required></label><br>
        <label>Product Image: <input type="file" name="productImage" required></label><br>
        <input type="submit" value="Add Clothing">
      </form>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
