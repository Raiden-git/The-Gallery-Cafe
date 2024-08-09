<?php
include('db_connect.php');
include('session_check.php');

$id = $_GET['id'];

$booking_sql = "SELECT * FROM parking_bookings WHERE id = $id";
$booking_result = $conn->query($booking_sql);
$booking = $booking_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $booking_time_start = $_POST['booking_time_start'];
    $booking_time_end = $_POST['booking_time_end'];

    $update_sql = "UPDATE parking_bookings SET 
        customer_name = '$name', 
        contact_number = '$contact_number', 
        booking_time_start = '$booking_time_start', 
        booking_time_end = '$booking_time_end' 
        WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Booking updated successfully!";
        echo "<script>window.location.href = 'parking_manage.php';</script>";
    } else {
        echo "Error updating booking: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
</head>
<body>

<h2>Edit Booking</h2>
<form action="" method="POST">
    <p>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= $booking['customer_name'] ?>" required>
    </p>
    <p>
        <label for="contact">Contact Number:</label>
        <input type="text" id="contact" name="contact_number" value="<?= $booking['contact_number'] ?>" required>
    </p>
    <p>
        <label for="start">Booking Start Time:</label>
        <input type="datetime-local" id="start" name="booking_time_start" value="<?= date('Y-m-d\TH:i', strtotime($booking['booking_time_start'])) ?>" required>
    </p>
    <p>
        <label for="end">Booking End Time:</label>
        <input type="datetime-local" id="end" name="booking_time_end" value="<?= date('Y-m-d\TH:i', strtotime($booking['booking_time_end'])) ?>" required>
    </p>
    <button type="submit">Update Booking</button>
</form>

</body>
</html>

<?php
$conn->close();
?>
