<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">	
</head>
<body>
    
    <?php
    // Display error message, if any
    if (isset($_GET['error'])) {
        echo "<p style='color:red;'>" . htmlspecialchars($_GET['error']) . "</p>";
    }
    ?>
	
	<header>
		<img src="_images/blackbanner.png" id="l_Logo" height="300" width="600">
	</header>
			
	<div class="form-container">
		
		<div class="box form-box">
			
			<h2>Login Page</h2>
			<form action="loginHandler.php" method="POST">
				<div class="field input">
					<label for="username">Username:</label>
					<input type="text" id="username" name="username" required>
				</div>

				<div class="field input">
					<label for="email">Email:</label>
					<input type="email" id="email" name="email" required>
				</div>

				<div class="field input">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" required>
				</div>
					
				<div class="field">
					<input type="submit" class="button" value="Login" height=35px>
				</div>
				
				<div class="link">
					<p>Don't have an account? <a href="register.php">Register here</a></p>
					<p> <a href="adminLogin.php">login as admin</a></p>
				</div>
				
			</form>
			
		</div>
	</div>
</body>
</html>
