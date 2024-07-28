<?php include('../partials/menu.php'); ?>

<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>

<?php
// Include the database connection file
include('db_connect.php');

// Handle reservation confirmation, modification, or cancellation
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $reservation_id = intval($_GET['id']);

    if ($action == 'confirm') {
        $stmt = $conn->prepare("UPDATE reservations SET status = 'Confirmed' WHERE id = ?");
    } elseif ($action == 'modify') {
        // Redirect to a modification page
        header("Location: modify_reservation.php?id=$reservation_id");
        exit();
    } elseif ($action == 'cancel') {
        $stmt = $conn->prepare("UPDATE reservations SET status = 'Cancelled' WHERE id = ?");
    } else {
        die('Invalid action.');
    }

    if (isset($stmt)) {
        $stmt->bind_param("i", $reservation_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Reservation ' . ($action == 'confirm' ? 'Confirmed' : ($action == 'cancel' ? 'Cancelled' : 'Modified')) . ' Successfully';
        } else {
            $_SESSION['message'] = 'Error: ' . $stmt->error;
        }
        $stmt->close();
        header("Location: reservation_management.php");
        exit();
    }
}

// Fetch all reservations
$result = $conn->query("SELECT * FROM reservations");

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
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
        .actions a { margin-right: 10px; }
        .message { padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
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
                                <a href="reservation_management.php?action=cancel&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Cancel</a>
                            <?php endif; ?>
                            <a href="reservation_management.php?action=modify&id=<?php echo $row['id']; ?>">Modify</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No reservations found.</p>
    <?php endif; ?>

    <?php
    // Close the connection
    $conn->close();
    ?>
<?php include('../partials/footer.php'); ?>
