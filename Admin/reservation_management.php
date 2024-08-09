<?php include('../partials/menu.php'); ?>



<?php
// Include the database connection file
include('db_connect.php');
include('session_check.php');

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
