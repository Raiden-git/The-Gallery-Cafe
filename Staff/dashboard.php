<?php
// Include the database connection file
include('../Admin/db_connect.php');
session_start(); // Start the session

// Fetch current reservations
$reservation_result = $conn->query("SELECT * FROM reservations ORDER BY reservation_date DESC");

// Fetch current pre-orders
$order_result = $conn->query("SELECT * FROM pre_orders ORDER BY order_date DESC");

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
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
        .message { padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Operational Staff Dashboard</h1>
    
    <!-- Display message -->
    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'Error') === false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Reservations Overview -->
    <h2>Current Reservations</h2>
    <?php if ($reservation_result && $reservation_result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Reservation Date</th>
                    <th>Number of Guests</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $reservation_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['reservation_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['number_of_guests']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td class="actions">
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a href="reservation_management.php?action=confirm&id=<?php echo $row['id']; ?>">Confirm</a>
                                <a href="reservation_management.php?action=cancel&id=<?php echo $row['id']; ?>">Cancel</a>
                                <a href="reservation_management.php?action=modify&id=<?php echo $row['id']; ?>">Modify</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No current reservations.</p>
    <?php endif; ?>

    <!-- Pre-Orders Overview -->
    <h2>Current Pre-Orders</h2>
    <?php if ($order_result && $order_result->num_rows > 0): ?>
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
                <?php while ($row = $order_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['items']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_amount']); ?></td>
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
        <p>No current pre-orders.</p>
    <?php endif; ?>

    <?php
    // Close the connection
    $conn->close();
    ?>
</body>
</html>
