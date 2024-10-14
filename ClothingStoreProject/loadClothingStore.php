<?php
include 'DBConn.php'; // Include the connection file

// Drop tables if they exist
$conn->query("DROP TABLE IF EXISTS tblUser, tblAdmin, tblClothes, tblAorder");

// Create tblUser table
$conn->query("
CREATE TABLE tblUser (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    UserName VARCHAR(50) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    status BOOLEAN DEFAULT FALSE
)");

// Create tblAdmin table
$conn->query("
CREATE TABLE tblAdmin (
    AdminID INT PRIMARY KEY AUTO_INCREMENT,
    AdminName VARCHAR(50) NOT NULL,
    AdminEmail VARCHAR(100) NOT NULL,
    Password VARCHAR(255) NOT NULL
)");

// Create tblClothes table with ProductImage column for storing image file path
$conn->query("
CREATE TABLE tblClothes (
    ClothingID INT PRIMARY KEY AUTO_INCREMENT,
    ClothingName VARCHAR(100) NOT NULL,
    Category VARCHAR(50),
    Price DECIMAL(10, 2),
    StockQuantity INT,
    ProductImage VARCHAR(255) NOT NULL
)");

// Create tblAorder table
$conn->query("
CREATE TABLE tblAorder (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    ClothingID INT,
    OrderDate DATE,
    Quantity INT,
    TotalPrice DECIMAL(10, 2),
    FOREIGN KEY (UserID) REFERENCES tblUser(UserID),
    FOREIGN KEY (ClothingID) REFERENCES tblClothes(ClothingID)
)");

echo "Tables created successfully!<br>";

// Load user data
if (file_exists("userData.txt")) {
    $dataFile = fopen("userData.txt", "r");
    while (($line = fgetcsv($dataFile)) !== FALSE) {
        $username = htmlspecialchars(trim($line[0]));
        $email = filter_var(trim($line[1]), FILTER_VALIDATE_EMAIL);
        $password = password_hash(trim($line[2]), PASSWORD_DEFAULT);
        
        if ($email && $password && $username) {
            $stmt = $conn->prepare("INSERT INTO tblUser (UserName, Email, Password, status) VALUES (?, ?, ?, ?)");
            $status = 0; // Default to unverified
            $stmt->bind_param("sssi", $username, $email, $password, $status);
            $stmt->execute();
        }
    }
    fclose($dataFile);
    echo "User data loaded successfully.<br>";
} else {
    echo "Error: userData.txt not found.<br>";
}

// Load admin data
if (file_exists("adminData.txt")) {
    $dataFile = fopen("adminData.txt", "r");
    while (($line = fgetcsv($dataFile)) !== FALSE) {
        $adminName = htmlspecialchars(trim($line[0]));
        $adminEmail = filter_var(trim($line[1]), FILTER_VALIDATE_EMAIL);
        $password = password_hash(trim($line[2]), PASSWORD_DEFAULT);
        
        if ($adminEmail && $password && $adminName) {
            $stmt = $conn->prepare("INSERT INTO tblAdmin (AdminName, AdminEmail, Password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $adminName, $adminEmail, $password);
            $stmt->execute();
        }
    }
    fclose($dataFile);
    echo "Admin data loaded successfully.<br>";
} else {
    echo "Error: adminData.txt not found.<br>";
}

// Load clothes data with image handling
if (file_exists("clothesData.txt")) {
    $dataFile = fopen("clothesData.txt", "r");
    while (($line = fgetcsv($dataFile)) !== FALSE) {
        $clothingName = htmlspecialchars(trim($line[0]));
        $category = htmlspecialchars(trim($line[1]));
        $price = floatval($line[2]);
        $stockQuantity = intval($line[3]);
        $productImage = htmlspecialchars(trim($line[4])); // Image path from the file

        // Insert clothes data into the tblClothes table
        $stmt = $conn->prepare("INSERT INTO tblClothes (ClothingName, Category, Price, StockQuantity, ProductImage) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $clothingName, $category, $price, $stockQuantity, $productImage);
        $stmt->execute();
    }
    fclose($dataFile);
    echo "Clothes data loaded successfully.<br>";
} else {
    echo "Error: clothesData.txt not found.<br>";
}

$conn->close();
?>

