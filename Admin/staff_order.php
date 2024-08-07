<?php
// Include the database connection file
include('../admin/db_connect.php');
include('session_check.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle order confirmation, modification, cancellation
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $order_id = intval($_GET['id']);

    if ($action == 'confirm') {
        $stmt = $conn->prepare("UPDATE pre_orders SET status = 'Confirmed' WHERE id = ?");
    } elseif ($action == 'modify') {
        // Redirect to a modification page
        header("Location: modify_order.php?id=$order_id");
        exit();
    } elseif ($action == 'cancel') {
        $stmt = $conn->prepare("UPDATE pre_orders SET status = 'Cancelled' WHERE id = ?");
    } else {
        die('Invalid action.');
    }

    if (isset($stmt)) {
        $stmt->bind_param("i", $order_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Order ' . ucfirst($action) . 'ed Successfully';
        } else {
            $_SESSION['message'] = 'Error: ' . $stmt->error;
        }
        $stmt->close();
        header("Location: order_management.php");
        exit();
    }
}

// Fetch all pre-orders
$sql_pre_orders = "SELECT pre_orders.id, pre_orders.customer_name, pre_orders.order_date, menu.name AS product_name, pre_orders.quantity, pre_orders.status 
                   FROM pre_orders 
                   JOIN menu ON pre_orders.product_id = menu.id";
$result_pre_orders = $conn->query($sql_pre_orders);

// Handle display of messages
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Clear the message after displaying it
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operational Staff Dashboard</title>
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #ffffff;
        }
        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .message.success {
            background-color: #4caf50;
            color: #ffffff;
        }
        .message.error {
            background-color: #f44336;
            color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #333333;
        }
        table tbody tr:nth-child(even) {
            background-color: #2c2c2c;
        }
        table tbody tr:nth-child(odd) {
            background-color: #1e1e1e;
        }
        table th, table td.actions {
            text-align: center;
        }
        .actions a {
            color: #ffffff;
            text-decoration: none;
            margin-right: 10px;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .actions a.confirm {
            background-color: #4caf50;
        }
        .actions a.cancel {
            background-color: #f44336;
        }
        .actions a.modify {
            background-color: #2196f3;
        }
        .actions a:hover {
            opacity: 0.8;
        }
    </style>
    <script>
        <?php if ($message): ?>
        alert("<?php echo htmlspecialchars($message); ?>");
        <?php endif; ?>
    </script>
</head>
<body>
    <h1>Operational Staff Dashboard</h1>
    
    <!-- Display message -->
    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'Error') === false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Pre-Orders Overview -->
    <h2>Current Pre-Orders</h2>
    <?php if ($result_pre_orders && $result_pre_orders->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_pre_orders->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td class="actions">
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a href="staff_order.php?action=confirm&id=<?php echo $row['id']; ?>" class="confirm">Confirm</a>
                                <a href="staff_order.php?action=modify&id=<?php echo $row['id']; ?>" class="modify">Modify</a>
                                <a href="staff_order.php?action=cancel&id=<?php echo $row['id']; ?>" class="cancel">Cancel</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pre-orders found.</p>
    <?php endif; ?>

    <?php
    // Close the connection
    $conn->close();
    ?>
</body>
</html>
