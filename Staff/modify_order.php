<?php
// Include the database connection file
include('../Admin/db_connect.php');
session_start(); // Start the session

// Handle order modification
if (isset($_POST['modify_order'])) {
    $order_id = intval($_POST['id']);
    $items = $_POST['items'];
    $total_amount = floatval($_POST['total_amount']);

    // Prepare an update statement
    $stmt = $conn->prepare("UPDATE pre_orders SET items = ?, total_amount = ? WHERE id = ?");
    $stmt->bind_param("sdi", $items, $total_amount, $order_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Order modified successfully.';
        header("Location: order_processing.php");
        exit();
    } else {
        $_SESSION['message'] = 'Error: ' . $stmt->error;
        header("Location: order_processing.php");
        exit();
    }

    $stmt->close();
}

// Fetch current data for the order to be modified
if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM pre_orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
} else {
    die('Order ID is required.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Order</title>
</head>
<body>
    <h1>Modify Order</h1>

    <!-- Display message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="message <?php echo strpos($_SESSION['message'], 'Error') === false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <!-- Modify Order Form -->
    <form action="modify_order.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['id']); ?>">
        <label for="items">Items:</label>
        <textarea id="items" name="items" required><?php echo htmlspecialchars($order['items']); ?></textarea>
        
        <label for="total_amount">Total Amount:</label>
        <input type="number" step="0.01" id="total_amount" name="total_amount" value="<?php echo htmlspecialchars($order['total_amount']); ?>" required>
        
        <button type="submit" name="modify_order">Modify Order</button>
    </form>
</body>
</html>
