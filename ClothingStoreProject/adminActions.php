<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: adminLogin.php");
    exit();
}
include 'DBConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = intval($_POST['userID']);
    $action = htmlspecialchars(trim($_POST['action']));

    switch ($action) {
        case 'verify':
            $sql = "UPDATE tblUser SET status = 1 WHERE UserID = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("i", $userID);
                if ($stmt->execute()) {
                    echo "User with ID $userID has been verified.";
                } else {
                    echo "Error verifying user: " . htmlspecialchars($stmt->error);
                }
            }
            break;

        case 'delete':
            $sql = "DELETE FROM tblUser WHERE UserID = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("i", $userID);
                if ($stmt->execute()) {
                    echo "User with ID $userID has been deleted.";
                } else {
                    echo "Error deleting user: " . htmlspecialchars($stmt->error);
                }
            }
            break;

        default:
            echo "Invalid action.";
            break;
    }

    $stmt->close();
}

$conn->close();
?>
