<?php
// admin_process_booking.php
include('db_connect.php');
include('session_check.php');

$space_code = $_POST['space_code'];
$name = $_POST['name'];
$contact_number = $_POST['contact_number'];
$booking_time_start = $_POST['booking_time_start'];
$booking_time_end = $_POST['booking_time_end'];

// Check if the selected space is available for the chosen time
$sql = "SELECT * FROM parking_bookings 
        WHERE space_code = '$space_code' 
        AND (
            ('$booking_time_start' BETWEEN booking_time_start AND booking_time_end) OR 
            ('$booking_time_end' BETWEEN booking_time_start AND booking_time_end)
        )";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "This space is already booked for the selected time.";
} else {
    // Insert booking record
    $sql = "INSERT INTO parking_bookings (customer_name, contact_number, space_code, booking_time_start, booking_time_end)
            VALUES ('$name', '$contact_number', '$space_code', '$booking_time_start', '$booking_time_end')";
    
    if ($conn->query($sql) === TRUE) {
        // Update parking space status to 'booked'
        $sql = "UPDATE parking_spaces SET status = 'booked' WHERE space_code = '$space_code'";
        $conn->query($sql);

        echo "Booking successful!";
        echo "<script>window.location.href = 'parking_manage.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
