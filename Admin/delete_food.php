<?php
// Include the database connection file
include('db_connect.php');

// Check if the ID is provided
if (isset($_GET['id'])) {
    $food_id = intval($_GET['id']);
    
    $stmt = $conn->prepare("DELETE FROM food_items WHERE id = ?");
    $stmt->bind_param("i", $food_id);

    if ($stmt->execute()) {
        echo '<p>Food item deleted successfully.</p>';
    } else {
        echo '<p>Error: ' . $stmt->error . '</p>';
    }

    $stmt->close();
    $conn->close();
}
?>
