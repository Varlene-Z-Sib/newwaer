<?php
session_start();
include 'DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);

    if ($username && $password) {
        $sql = "SELECT * FROM tblAdmin WHERE AdminName = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            if (password_verify($password, $admin['Password'])) {
                session_regenerate_id(true);
                $_SESSION['Admin_ID'] = $admin['AdminID'];
                header("Location: adminDashboard.php");
            } else {
                header("Location: adminLogin.php?error=Invalid password.");
            }
        } else {
            header("Location: adminLogin.php?error=Admin user not found.");
        }

        $stmt->close();
    } else {
        header("Location: adminLogin.php?error=Invalid input.");
    }

    $conn->close();
}
?>
