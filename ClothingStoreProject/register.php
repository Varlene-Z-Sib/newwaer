<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<header>
		<img src="_images/blackbanner.png" id="l_Logo" height="300" width="600">
	</header>
	
	<div class="form-container">	
		<div class="box form-box">
			<h2>Register Page</h2>
			<form action="registerHandler.php" method="POST">
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
				<input type="submit" value="Register" class="button">
				</div>
				
				<div class="link">
					<p>Already have an account? <a href="login.php">Sign in</a></p>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
