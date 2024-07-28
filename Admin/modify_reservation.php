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


// Handle the modification request
if (isset($_POST['modify_reservation'])) {
    $reservation_id = intval($_POST['id']);
    $customer_name = $_POST['customer_name'];
    $reservation_date = $_POST['reservation_date'];
    $number_of_guests = intval($_POST['number_of_guests']);

    // Prepare an update statement
    $stmt = $conn->prepare("UPDATE reservations SET customer_name = ?, reservation_date = ?, number_of_guests = ? WHERE id = ?");
    $stmt->bind_param("ssii", $customer_name, $reservation_date, $number_of_guests, $reservation_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Reservation modified successfully.';
        header("Location: reservation_management.php");
        exit();
    } else {
        $_SESSION['message'] = 'Error: ' . $stmt->error;
        header("Location: reservation_management.php");
        exit();
    }

    $stmt->close();
}

// Fetch the current data for the reservation to be modified
if (isset($_GET['id'])) {
    $reservation_id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM reservations WHERE id = ?");
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservation = $result->fetch_assoc();
    $stmt->close();
} else {
    die('Reservation ID is required.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Reservation</title>
</head>
<body>
    <h1>Modify Reservation</h1>

    <!-- Display message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="message <?php echo strpos($_SESSION['message'], 'Error') === false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <!-- Modify Reservation Form -->
    <form action="modify_reservation.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($reservation['id']); ?>">
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($reservation['customer_name']); ?>" required>
        <label for="reservation_date">Reservation Date:</label>
        <input type="datetime-local" id="reservation_date" name="reservation_date" value="<?php echo htmlspecialchars($reservation['reservation_date']); ?>" required>
        <label for="number_of_guests">Number of Guests:</label>
        <input type="number" id="number_of_guests" name="number_of_guests" value="<?php echo htmlspecialchars($reservation['number_of_guests']); ?>" required>
        <button type="submit" name="modify_reservation">Modify Reservation</button>
    </form>
</body>
</html>
