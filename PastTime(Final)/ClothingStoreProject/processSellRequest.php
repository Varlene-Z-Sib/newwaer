<?php
// processSellRequest.php

session_start();
include 'DBConn.php'; // Database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in to submit a sell request.");
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = $conn->real_escape_string($_POST['name']);
    $brand = $conn->real_escape_string($_POST['brand']);
    $category = $conn->real_escape_string($_POST['category']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = (float)$_POST['price'];

    // Handle file upload
    $target_dir = "_images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate file type and upload image
    if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert data into the database, including user_id
            $sql = "INSERT INTO tblSellRequests (UserID, name, brand, category, description, price, image_path) 
                    VALUES ($user_id, '$name', '$brand', '$category', '$description', $price, '$target_file')";
            
            if ($conn->query($sql) === TRUE) {
                /*echo "Your sell request was submitted successfully!";
				header("Location: sellRequest.php");*/
				echo "<script>alert('Your sell request was submitted successfully!'); window.location.href = 'sellRequest.php';</script>";
            } else {
                /*echo "Database error: " . $conn->error;*/
				echo "<script>alert('Database error: " . $conn->error . "'); window.location.href = 'sellRequest.php';</script>";
				
            }
        } else {
            /*echo "Error uploading image.";*/			
			echo "<script>alert('Error uploading image.'); window.location.href = 'sellRequest.php';</script>";
        }
    } else {
        /*echo "Invalid file type. Only JPG, PNG, JPEG, and GIF are allowed.";*/
		echo "<script>alert('Invalid file type. Only JPG, PNG, JPEG, and GIF are allowed.'); window.location.href = 'sellRequest.php';</script>";
    }
} else {
    /*echo "Invalid request.";*/
	echo "<script>alert('Invalid request.'); window.location.href = 'sellRequest.php';</script>";
}
	

$conn->close();
?>
