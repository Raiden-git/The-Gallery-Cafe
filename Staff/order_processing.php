<?php
// Include the database connection file
include('../Admin/db_connect.php');
session_start(); // Start the session

// Handle order actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $order_id = intval($_GET['id']);

    if ($action == 'confirm') {
        $stmt = $conn->prepare("UPDATE pre_orders SET status = 'Confirmed' WHERE id = ?");
    } elseif ($action == 'cancel') {
        $stmt = $conn->prepare("UPDATE pre_orders SET status = 'Cancelled' WHERE id = ?");
    } elseif ($action == 'modify') {
        // Redirect to the modification page
        header("Location: modify_order.php?id=$order_id");
        exit();
    } else {
        die('Invalid action.');
    }

    if (isset($stmt)) {
        $stmt->bind_param("i", $order_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Order ' . ($action == 'confirm' ? 'Confirmed' : 'Cancelled') . ' Successfully';
        } else {
            $_SESSION['message'] = 'Error: ' . $stmt->error;
        }
        $stmt->close();
        header("Location: order_processing.php");
        exit();
    }
}

// Fetch all orders
$result = $conn->query("SELECT * FROM pre_orders ORDER BY order_date DESC");

// Handle display of messages
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Clear the message after displaying it

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Processing</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
        .actions a { margin-right: 10px; }
        .message { padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Order Processing</h1>
    
    <!-- Display message -->
    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'Error') === false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Display Current Orders -->
    <h2>Current Pre-Orders</h2>
    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Items</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['items']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td class="actions">
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a href="order_processing.php?action=confirm&id=<?php echo $row['id']; ?>">Confirm</a>
                                <a href="order_processing.php?action=cancel&id=<?php echo $row['id']; ?>">Cancel</a>
                                <a href="order_processing.php?action=modify&id=<?php echo $row['id']; ?>">Modify</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No current pre-orders.</p>
    <?php endif; ?>

    <?php
    // Close the connection
    $conn->close();
    ?>
</body>
</html>
