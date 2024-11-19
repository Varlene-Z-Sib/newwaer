<?php
include 'DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);

    if ($email && $password && $username) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO tblUser (UserName, Email, Password, status) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $status = 0; // Default to unverified
        $stmt->bind_param("sssi", $username, $email, $hashed_password, $status);

        if ($stmt->execute()) {
           /* echo "Registration successful! Wait for admin verification.";*/
			echo "<script>alert('Registration successful! Wait for admin verification.');</script>";
            header("Location: login.php");
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
       /* echo "Invalid input data.";*/
		echo "<script>alert('Invalid input data.');</script>";
    }

    $conn->close();
}
?>
