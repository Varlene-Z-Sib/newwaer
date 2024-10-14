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
					<li><a href="index.php">Home</a></li>			
					<li class="currentPage">Admin Dashboard</a></li>
				</ul>
			</nav>
		</div>
			
			<div id="banner">
				<img src="_images/shirtbanner.jpg" id="l_Logo" height="300">
			</div>
    </header>
	
	<div class="tablecontainer">
		<?php
		session_start();
		include 'DBConn.php';

		// Check if the admin is logged in
		if (!isset($_SESSION['admin_username'])) {
			header("Location: adminLogin.php");
			exit();
		}

		echo "<h2>Welcome, Admin: " . htmlspecialchars($_SESSION['admin_username']) . "</h2>";
		echo "<a href='logout.php'>Logout</a>";
		echo "<h3>User List</h3>";

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
				// Use the correct field names here: UserName, Email, and status
				echo "<tr>
						<td>" . htmlspecialchars($row['UserID']) . "</td>
						<td>" . htmlspecialchars($row['UserName']) . "</td>
						<td>" . htmlspecialchars($row['Email']) . "</td>
						<td>" . ($row['status'] ? 'Yes' : 'No') . "</td>
						<td>
							<form method='POST' action='adminActions.php'>
								<input type='hidden' name='userID' value='" . htmlspecialchars($row['UserID']) . "' />
								<select name='action'>
									<option value='verify'>Verify</option>
									<option value='delete'>Delete</option>
								</select>
								<input type='submit' value='Submit' />
							</form>
						</td>
					  </tr>";
			}
			echo "</table>";
		} else {
			echo "No users found.";
		}

		$conn->close();
		?>
	</div>
   </body>
</html>
