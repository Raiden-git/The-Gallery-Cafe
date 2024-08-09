<?php
// admin_book_space.php
include('db_connect.php');
include('session_check.php');

$space_code = $_GET['space_code'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Book Space</title>
</head>
<body>

<h2>Book Parking Space</h2>
<form action="admin_process_booking.php" method="POST">
    <input type="hidden" name="space_code" value="<?= $space_code ?>" readonly>
    <p>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </p>
    <p>
        <label for="contact">Contact Number:</label>
        <input type="text" id="contact" name="contact_number" required>
    </p>
    <p>
        <label for="start">Booking Start Time:</label>
        <input type="datetime-local" id="start" name="booking_time_start" required>
    </p>
    <p>
        <label for="end">Booking End Time:</label>
        <input type="datetime-local" id="end" name="booking_time_end" required>
    </p>
    <button type="submit">Book Now</button>
</form>

</body>
</html>
