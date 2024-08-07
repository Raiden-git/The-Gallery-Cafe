<?php
// Include the database connection file
include('../Admin/db_connect.php');
session_start(); // Start the session

// Handle reservation actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $reservation_id = intval($_GET['id']);

    if ($action == 'confirm') {
        $stmt = $conn->prepare("UPDATE reservations SET status = 'Confirmed' WHERE id = ?");
    } elseif ($action == 'cancel') {
        $stmt = $conn->prepare("UPDATE reservations SET status = 'Cancelled' WHERE id = ?");
    } elseif ($action == 'modify') {
        // Redirect to the modification page
        header("Location: modify_reservation.php?id=$reservation_id");
        exit();
    } else {
        die('Invalid action.');
    }

    if (isset($stmt)) {
        $stmt->bind_param("i", $reservation_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Reservation ' . ($action == 'confirm' ? 'Confirmed' : 'Cancelled') . ' Successfully';
        } else {
            $_SESSION['message'] = 'Error: ' . $stmt->error;
        }
        $stmt->close();
        header("Location: reservation_management.php");
        exit();
    }
}

// Fetch all reservations
$result = $conn->query("SELECT * FROM reservations ORDER BY reservation_date DESC");

// Handle display of messages
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Clear the message after displaying it

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Management</title>
    <style>
        <style>
        body {
            background-color: #1a1a1a;
            color: #e0e0e0;
            font-family: Arial, sans-serif;
        }
        h1, h2 {
            color: #f5f5f5;
        }
        .message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
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
            margin: 20px 0;
            background-color: #2a2a2a;
            color: #ffffff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #444;
            text-align: left;
        }
        th {
            background-color: #333;
        }
        .actions a {
            color: #1e90ff;
            text-decoration: none;
            margin-right: 10px;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        a {
            color: #1e90ff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
    </style>
</head>
<body>
    <h1>Reservation Management</h1>
    
    <!-- Display message -->
    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'Error') === false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Display Current Reservations -->
    <h2>Current Reservations</h2>
    <?php if ($result && $result->num_rows > 0): ?>
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
                <?php while ($row = $result->fetch_assoc()): ?>
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

    <?php
    // Close the connection
    $conn->close();
    ?>
</body>
</html>
