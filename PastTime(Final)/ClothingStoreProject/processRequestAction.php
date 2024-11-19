<?php
// processRequestAction.php

session_start();
include 'DBConn.php'; // Database connection file

// Check if the admin is logged in (optional based on your system)
if (!isset($_SESSION['Admin_ID'])) {
    die("Please log in as an admin to manage sell requests.");
}

if (isset($_POST['requestID']) && isset($_POST['action'])) {
    $requestID = $_POST['requestID'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        $sql = "UPDATE tblSellRequests SET status='Approved' WHERE request_id=?";
    } elseif ($action == 'reject') {
        $sql = "UPDATE tblSellRequests SET status='Rejected' WHERE request_id=?";
    } elseif ($action == 'delete') {
        $sql = "DELETE FROM tblSellRequests WHERE request_id=?";
    }

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $requestID);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect back to the requests page
    header("Location: viewRequests.php");
} else {
    echo "Invalid action or request ID.";
}

$conn->close();
?>
