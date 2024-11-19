<!-- adminLogin.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
	
	<script>
			function showErrorMessage(message) {
				alert(message);
        }
    </script>
</head>
<body>
	<header>
		<img src="_images/blackbanner.png" id="l_Logo" height="300" width="600">
	</header>
	
	<div class="form-container">	
		<div class="box form-box">
        <h2>Admin Login</h2>
        <form action="adminLoginHandler.php" method="POST">
			<div class="field input">
				<label for="username">Username:</label>
				<input type="text" id="username" name="username" required><br>
			</div>
			
			<div class="field input">
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" required><br>
			</div>
			
			<div class="field">
				<button type="submit" class="button">Login</button>
			</div>
			
			<div class="link">
			
					<p><a href="login.php">Login as user </a></p>
				</div>
        </form>
        <p class="error">
			<?php
				if (isset($_GET['error'])) {
					echo "<script>showErrorMessage('" . $_GET['error'] . "');</script>";
			}
			?>
        </p>
		</div>
    </div>
</body>
</html>
