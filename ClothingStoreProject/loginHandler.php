<?php
session_start();
include 'DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);

    if ($email && $password && $username) {
        $sql = "SELECT * FROM tblUser WHERE UserName = ? AND Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['Password'])) {
                if ($user['status'] == 1) {
                    // Regenerate session ID for security
                    session_regenerate_id(true);
                    $_SESSION['username'] = $user['UserName'];

                    // Redirect to index.php
                    header("Location: index.php");
                    exit();
                } else {
                    header("Location: login.php?error=User not verified. Please wait for admin approval.");
                }
            } else {
                header("Location: login.php?error=Incorrect password.");
            }
        } else {
            header("Location: login.php?error=User not found. Please register.");
        }
    } else {
        header("Location: login.php?error=Invalid input.");
    }

    $stmt->close();
    $conn->close();
}
?>
