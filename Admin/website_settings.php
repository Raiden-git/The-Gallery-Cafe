<?php include('../partials/menu.php'); ?>

<?php
// Include the database connection file
include('db_connect.php');
include('session_check.php');

// Handle form submission to update settings
if (isset($_POST['update_settings'])) {
    $restaurant_info = $_POST['restaurant_info'];
    $promotions = $_POST['promotions'];

    // Prepare an update statement
    $stmt = $conn->prepare("UPDATE settings SET restaurant_info = ?, promotions = ? WHERE id = 1");
    $stmt->bind_param("ss", $restaurant_info, $promotions);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Settings updated successfully.';
    } else {
        $_SESSION['message'] = 'Error: ' . $stmt->error;
    }
    $stmt->close();
    header("Location: website_settings.php");
    exit();
}

// Fetch current settings
$result = $conn->query("SELECT * FROM settings WHERE id = 1");
$settings = $result->fetch_assoc();
$result->free();

// Handle display of messages
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Clear the message after displaying it

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Settings</title>
    <style>
        form { margin-top: 20px; }
        label { display: block; margin-top: 10px; }
        textarea { width: 100%; height: 150px; }
        .message { padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Website Settings</h1>
    
    <!-- Display message -->
    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'Error') === false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Website Settings Form -->
    <form action="website_settings.php" method="POST">
        <label for="restaurant_info">Restaurant Information:</label>
        <textarea id="restaurant_info" name="restaurant_info" required><?php echo htmlspecialchars($settings['restaurant_info']); ?></textarea>
        
        <label for="promotions">Promotions:</label>
        <textarea id="promotions" name="promotions" required><?php echo htmlspecialchars($settings['promotions']); ?></textarea>
        
        <button type="submit" name="update_settings">Update Settings</button>
    </form>

    <?php include('../partials/footer.php'); ?>
