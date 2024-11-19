<style>
		
        /* Styling remains the same */
		
        body { background-color: #000; color: #1E90FF; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100%; margin: 20px; }
		
        .container {
            background-color: #1A1A1A; /* Dark gray for container */
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
		
		h2 { color: #00b0ff; margin-bottom: 20px; }
		
        label { display: block; text-align: left; margin: 10px 0 5px; color: #b3b3b3; }
		
        input[type="text"], input[type="number"], textarea, input[type="file"] {
            width: 100%; padding: 10px; margin-bottom: 15px; background-color: #2b2b2b; border: 1px solid #444; border-radius: 4px; color: #f1f1f1; font-size: 14px;
        }
		
        input[type="submit"] { background-color: #00b0ff; color: #fff; font-size: 16px; padding: 10px; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease; }
        input[type="submit"]:hover { background-color: #0081c2; }
    </style>	

<?php
include 'DBConn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // Update User
    if ($action === 'updateUser' && isset($_POST['userID'])) {
        $userID = intval($_POST['userID']);
        $sql = "SELECT * FROM tblUser WHERE UserID = $userID";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            ?>
			<div class="form-container">			
				<div class="box form-box">				
			<h2>Update User Details</h2>
            <form method="POST" action="adminActions.php">
			
                <input type="hidden" name="action" value="submitUserUpdate">
                <input type="hidden" name="userID" value="<?php echo $userID; ?>">
				
                <label>Username: <input type="text" name="userName" value="<?php echo htmlspecialchars($user['UserName']); ?>" required></label><br>
                <label>Email: <input type="text" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required></label><br>
				
                <input type="submit" value="Update User">
            </form>
			</div>
			<br>
			<a href="adminDashboard.php">Home</a></div> 
            <?php
        } else {
            echo "User not found.";
        }
    }

    // Submit User Update
    if ($action === 'submitUserUpdate' && isset($_POST['userID'])) {
        $userID = intval($_POST['userID']);
        $userName = htmlspecialchars(trim($_POST['userName']));
        $email = htmlspecialchars(trim($_POST['email']));
        $sql = "UPDATE tblUser SET UserName='$userName', Email='$email' WHERE UserID=$userID";
        if ($conn->query($sql)) {
            /*echo "User updated successfully.";*/
			echo "<script>alert('User updated successfully.'); window.location.href = 'adminDashboard.php';</script>";
        } else {
            /*echo "Error updating user: " . $conn->error;*/
			echo "<script>alert('Error updating user: " . $conn->error . "'); window.location.href = 'adminDashboard.php';</script>";
        }
    }

    // Verify User
    if ($action === 'verifyUser' && isset($_POST['userID'])) {
        $userID = intval($_POST['userID']);
        $sql = "UPDATE tblUser SET status=1 WHERE UserID=$userID";
        if ($conn->query($sql)) {
			echo "<script>alert('User verified successfully.'); window.location.href = 'adminDashboard.php';</script>";
        } else {
			 echo "<script>alert('Error verifying user: " . $conn->error . "'); window.location.href = 'adminDashboard.php';</script>";
        }
    }

    // Add User
    if ($action === 'addUser') {
        $userName = htmlspecialchars(trim($_POST['userName']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $sql = "INSERT INTO tblUser (UserName, Email, password) VALUES ('$userName', '$email', '$password')";
        if ($conn->query($sql)) {
            /*echo "User added successfully.";*/
			echo "<script>alert('User added successfully.'); window.location.href = 'adminDashboard.php';</script>";
        } else {
            /*echo "Error adding user: " . $conn->error;*/
			echo "<script>alert('Error adding user: " . $conn->error . "'); window.location.href = 'adminDashboard.php';</script>";
        }
    }

    // Add Clothing
    elseif ($action === 'addClothing') {
        $clothingName = htmlspecialchars(trim($_POST['clothingName']));
        $category = htmlspecialchars(trim($_POST['category']));
        $price = floatval($_POST['price']);
        $stockQuantity = intval($_POST['stockQuantity']);
        if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
            $imageFileName = '_images/' . basename($_FILES['productImage']['name']);
            move_uploaded_file($_FILES['productImage']['tmp_name'], $imageFileName);
        } else {
            echo "Error uploading image.";
            exit();
        }
        $sql = "INSERT INTO tblClothes (ClothingName, Category, Price, StockQuantity, ProductImage)
                VALUES ('$clothingName', '$category', $price, $stockQuantity, '$imageFileName')";
        if ($conn->query($sql)) {
            /*echo "Clothing item added successfully.";*/
			echo "<script>alert('Clothing item added successfully.'); window.location.href = 'adminDashboard.php';</script>";
        } else {
            /*echo "Error adding clothing item: " . $conn->error;*/
			echo "<script>alert('Error adding clothing item: " . $conn->error . "'); window.location.href = 'adminDashboard.php';</script>";
        }
    }

    // Update Clothing
    if ($action === 'updateClothing' && isset($_POST['clothingID'])) {
        $clothingID = intval($_POST['clothingID']);
        $sql = "SELECT * FROM tblClothes WHERE ClothingID=$clothingID";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $clothing = $result->fetch_assoc();
            ?>
			<div class="form-container">			
				<div class="box form-box">				
			<h2>Update Clothing Details</h2>
            <form method="POST" action="adminActions.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="submitClothingUpdate">
                <input type="hidden" name="clothingID" value="<?php echo $clothingID; ?>">
                <label>Clothing Name: <input type="text" name="clothingName" value="<?php echo htmlspecialchars($clothing['ClothingName']); ?>" required></label><br>
                <label>Category: <input type="text" name="category" value="<?php echo htmlspecialchars($clothing['Category']); ?>" required></label><br>
                <label>Price: <input type="number" step="0.01" name="price" value="<?php echo $clothing['Price']; ?>" required></label><br>
                <label>Stock Quantity: <input type="number" name="stockQuantity" value="<?php echo $clothing['StockQuantity']; ?>" required></label><br>
                <label>Product Image: <input type="file" name="productImage"></label><br>
                <input type="submit" value="Update Clothing">
				
            </form>			
			</div>
			<br>
			<a href="adminDashboard.php">Home</a></div> 
            <?php
        } else {
            echo "Clothing not found.";
        }
    }
	

    // Submit Clothing Update
    if ($action === 'submitClothingUpdate' && isset($_POST['clothingID'])) {
        $clothingID = intval($_POST['clothingID']);
        $clothingName = htmlspecialchars(trim($_POST['clothingName']));
        $category = htmlspecialchars(trim($_POST['category']));
        $price = floatval($_POST['price']);
        $stockQuantity = intval($_POST['stockQuantity']);
        $updateImage = "";

        if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
            $imageFileName = '_images/' . basename($_FILES['productImage']['name']);
            move_uploaded_file($_FILES['productImage']['tmp_name'], $imageFileName);
            $updateImage = ", ProductImage='$imageFileName'";
        }

        $sql = "UPDATE tblClothes SET ClothingName='$clothingName', Category='$category', Price=$price, StockQuantity=$stockQuantity $updateImage WHERE ClothingID=$clothingID";
        if ($conn->query($sql)) {
            /*echo "Clothing updated successfully.";*/
			echo "<script>alert('Clothing updated successfully.'); window.location.href = 'adminDashboard.php';</script>";
        } else {
            /*echo "Error updating clothing: " . $conn->error;*/
			echo "<script>alert('Error updating clothing: " . $conn->error . "'); window.location.href = 'adminDashboard.php';</script>";
        }
    }

    // Delete User
    if ($action === 'deleteUser' && isset($_POST['userID'])) {
        $userID = intval($_POST['userID']);
        $sql = "DELETE FROM tblUser WHERE UserID=$userID";
        if ($conn->query($sql)) {
           /* echo "User deleted successfully.";*/
			echo "<script>alert('User deleted successfully.'); window.location.href = 'adminDashboard.php';</script>";
        } else {
           /* echo "Error deleting user: " . $conn->error;*/
			echo "<script>alert('Error deleting user: " . $conn->error . "'); window.location.href = 'adminDashboard.php';</script>";
        }
    }

    // Delete Clothing
    if ($action === 'deleteClothing' && isset($_POST['clothingID'])) {
        $clothingID = intval($_POST['clothingID']);
        $sql = "DELETE FROM tblClothes WHERE ClothingID=$clothingID";
        if ($conn->query($sql)) {
            /*echo "Clothing deleted successfully.";*/
			echo "<script>alert('Clothing deleted  successfully.'); window.location.href = 'adminDashboard.php';</script>";
        } else {
           /* echo "Error deleting clothing: " . $conn->error;*/
			echo "<script>alert('Error deleting clothing: " . $conn->error . "'); window.location.href = 'adminDashboard.php';</script>";
        }
    }
	
}
$conn->close();
?>
