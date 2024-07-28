<?php
// delete_user.php

// Include the database connection file
include('db_connect.php');

// Check if user ID is provided
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo '<p>User deleted successfully.</p>';
    } else {
        echo '<p>Error: ' . $stmt->error . '</p>';
    }

    $stmt->close();
}

// Close connection
$conn->close();

// Redirect back to manage_users.php
header("Location: manage_users.php");
exit();
?>
