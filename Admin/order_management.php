<?php include('../partials/menu.php'); ?>

<?php
// Include the database connection file
include('db_connect.php');
include('session_check.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle order confirmation, modification
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $order_id = intval($_GET['id']);

    if ($action == 'confirm') {
        $stmt = $conn->prepare("UPDATE pre_orders SET status = 'Confirmed' WHERE id = ?");
    } elseif ($action == 'modify') {
        // Redirect to a modification page
        header("Location: modify_order.php?id=$order_id");
        exit();
    } else {
        die('Invalid action.');
    }

    if (isset($stmt)) {
        $stmt->bind_param("i", $order_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Order ' . ($action == 'confirm' ? 'Confirmed' : 'Modified') . ' Successfully';
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
    <title>Order Management</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        
        table {
            width: 90%;
            border-collapse: collapse;
            margin-left: auto; 
            margin-right: auto;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        th {
            background-color: #1f1f1f;
        }

        tr:nth-child(even) {
            background-color: #1f1f1f;
        }

        tr:hover {
            background-color: #333;
        }

        a {
            color: #bb86fc;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #333;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #bb86fc;
            color: #121212;
        }

        button {
            background-color: #bb86fc;
            color: #121212;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #7f39fb;
        }
        

        h2 {
            margin-bottom: 20px;
            color: #ffffff;
        }

        h3 {
            color: #ffffff;
        }

        footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;

    width: 100%;
    bottom: 0;
}
    </style>
</head>
<body>
    <h1>Order Management</h1>
    
    <!-- Display message -->
    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'Error') === false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Display Current Pre-Orders -->
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
                                <a href="order_management.php?action=confirm&id=<?php echo $row['id']; ?>">Confirm</a>
                                <a href="order_management.php?action=modify&id=<?php echo $row['id']; ?>">Modify</a>
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

<?php include('../partials/footer.php'); ?>
