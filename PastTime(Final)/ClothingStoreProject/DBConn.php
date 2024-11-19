<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = ""; // Default WAMP password is empty
$dbname = "ClothingStore";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
