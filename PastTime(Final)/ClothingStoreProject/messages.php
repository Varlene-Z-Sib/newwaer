<?php
session_start();
include 'DBConn.php'; // Include the connection file

// Check if user or admin is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $is_admin = false;
} elseif (isset($_SESSION['Admin_ID'])) {
    $user_id = $_SESSION['Admin_ID'];
    $is_admin = true;
} else {
    die("Please log in to send and view messages.");
}
// Function to clear all messages for the logged-in user
function clearAllMessages($user_id, $is_admin, $conn) {
    // SQL query to delete messages where the logged-in user is the sender or receiver
    if ($is_admin) {
        // Admin can clear messages from both users and admins
        $sql = "DELETE FROM tblMessages WHERE sender_id = ? OR receiver_id = ?";
    } else {
        // User can only clear messages they have sent or received
        $sql = "DELETE FROM tblMessages WHERE sender_id = ? OR receiver_id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $user_id); // Bind the user/admin ID to the query

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Check if the user clicked to clear all messages
if (isset($_POST['clear_messages'])) {
    if (clearAllMessages($user_id, $is_admin, $conn)) {
        echo "All messages cleared successfully.";
    } else {
        echo "Error clearing messages. Please try again.";
    }
}
// Handle sending a message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_content'], $_POST['receiver_username'])) {
    $receiver_username = $_POST['receiver_username'];  // The username of the recipient
    $message_content = $_POST['message_content']; // Content of the message

    // Fetch the receiver's ID based on the username
    if ($is_admin) {
        // Admin sending message to a user
        $sql = "SELECT UserID FROM tblUser WHERE UserName = ?";
    } else {
        // User sending message to admin
        $sql = "SELECT AdminID FROM tblAdmin WHERE AdminName = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $receiver_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Get the receiver's ID
        $receiver_id = $is_admin ? $row['UserID'] : $row['AdminID'];

        // Insert the message into the database
        $insert_sql = "INSERT INTO tblMessages (sender_id, receiver_id, message_content) 
                       VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iis", $user_id, $receiver_id, $message_content);

        if ($insert_stmt->execute()) {
            echo "Message sent successfully!";
        } else {
            echo "Error sending message: " . $conn->error;
        }

        $insert_stmt->close();
    } else {
        echo "User or Admin with that username not found.";
    }

    $stmt->close();
}

// Fetch messages for the logged-in user or admin, filtering by the targeted recipient
if ($is_admin) {
    // Admin can see messages sent to them and messages they sent
    $sql = "SELECT tblMessages.*, 
                   tblUser.UserName AS sender_name, 
                   tblAdmin.AdminName AS receiver_name
            FROM tblMessages
            LEFT JOIN tblUser ON tblMessages.sender_id = tblUser.UserID
            LEFT JOIN tblAdmin ON tblMessages.receiver_id = tblAdmin.AdminID
            WHERE (tblMessages.sender_id = ? AND tblMessages.receiver_id = ?) 
            OR (tblMessages.sender_id = ? AND tblMessages.receiver_id = ?)
            ORDER BY tblMessages.timestamp DESC";
} else {
    // User can see messages sent to them and messages they sent
    $sql = "SELECT tblMessages.*, 
                   tblUser.UserName AS sender_name, 
                   tblAdmin.AdminName AS receiver_name
            FROM tblMessages
            LEFT JOIN tblUser ON tblMessages.sender_id = tblUser.UserID
            LEFT JOIN tblAdmin ON tblMessages.receiver_id = tblAdmin.AdminID
            WHERE (tblMessages.sender_id = ? AND tblMessages.receiver_id = ?) 
            OR (tblMessages.sender_id = ? AND tblMessages.receiver_id = ?)
            ORDER BY tblMessages.timestamp DESC";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $user_id, $receiver_id, $user_id, $receiver_id);  // Both sender_id and receiver_id
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #3498db;
            margin-top: 50px;
        }

        h2 {
            color: #3498db;		
			padding-LEFT: 10%;
        }

        form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #333;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        input[type="text"], textarea {
            width:95%;
            padding: 10px;
            margin-bottom: 15px;			
            margin-top: 15px;
            border: 1px solid #ccc;	
            border-radius: 4px;
            background-color: #222;
            color: #fff;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .messages {
            margin: 20px auto;
            width: 80%;
            padding: 10px;
            background-color: #333;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        .message {
            margin: 10px 0;
            padding: 10px;
            background-color: #444;
            border-radius: 4px;
            color: #ddd;
        }

        .message strong {
            color: #3498db;
        }

        footer {
            text-align: center;
            margin-top: 30px;
        }

        footer a {
            color: #3498db;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Messages</h1>
	<!-- Clear All Messages Button -->
    <form method="POST" action="">
        <input type="submit" name="clear_messages" value="Clear All Messages" style="background-color: red; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
    </form>

    <!-- Message Sending Form -->
    <form method="POST" action="">
        <label for="receiver_username">Receiver Username:</label>
        <input type="text" id="receiver_username" name="receiver_username" required placeholder="Enter receiver's username">
        
        <label for="message_content">Message:</label>
        <textarea id="message_content" name="message_content" required placeholder="Enter your message"></textarea>

        <input type="submit" value="Send Message">
    </form>

    <!-- Display Sent Messages -->
    <h2>Sent Messages</h2>
    <div class="messages">
        <?php
        // Display Sent Messages
        $stmt_sent = $conn->prepare("SELECT tblMessages.*, 
                                            tblUser.UserName AS sender_name, 
                                            tblAdmin.AdminName AS receiver_name 
                                     FROM tblMessages 
                                     LEFT JOIN tblUser ON tblMessages.sender_id = tblUser.UserID 
                                     LEFT JOIN tblAdmin ON tblMessages.receiver_id = tblAdmin.AdminID 
                                     WHERE tblMessages.sender_id = ? ORDER BY tblMessages.timestamp DESC");
        $stmt_sent->bind_param("i", $user_id);
        $stmt_sent->execute();
        $result_sent = $stmt_sent->get_result();

        if ($result_sent->num_rows > 0) {
            while ($row = $result_sent->fetch_assoc()) {
                echo "<div class='message'><strong>Sent to " . htmlspecialchars($row['receiver_name']) . ":</strong> " . htmlspecialchars($row['message_content']) . " <em>at " . $row['timestamp'] . "</em></div>";
            }
        } else {
            echo "No sent messages.";
        }
        ?>
    </div>

    <!-- Display Received Messages -->
    <h2>Received Messages</h2>
    <div class="messages">
        <?php
        // Display Received Messages
        $stmt_received = $conn->prepare("SELECT tblMessages.*, 
                                                tblUser.UserName AS sender_name, 
                                                tblAdmin.AdminName AS receiver_name 
                                         FROM tblMessages 
                                         LEFT JOIN tblUser ON tblMessages.sender_id = tblUser.UserID 
                                         LEFT JOIN tblAdmin ON tblMessages.receiver_id = tblAdmin.AdminID 
                                         WHERE tblMessages.receiver_id = ? ORDER BY tblMessages.timestamp DESC");
        $stmt_received->bind_param("i", $user_id);
        $stmt_received->execute();
        $result_received = $stmt_received->get_result();

        if ($result_received->num_rows > 0) {
            while ($row = $result_received->fetch_assoc()) {
                echo "<div class='message'><strong>Received from " . htmlspecialchars($row['sender_name']) . ":</strong> " . htmlspecialchars($row['message_content']) . " <em>at " . $row['timestamp'] . "</em></div>";
            }
        } else {
            echo "No received messages.";
        }
        ?>
    </div>

    <footer>
        <a href="logout.php">Logout</a><br><a href="adminDashboard.php">adminDashboard</a><br><a href="index.php">Home</a>
    </footer>
</body>
</html>
