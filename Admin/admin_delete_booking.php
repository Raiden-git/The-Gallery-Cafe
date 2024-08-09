<?php
// admin_delete_booking.php
include('db_connect.php');
include('session_check.php');

$id = $_GET['id'] ?? null;
$space_code = $_GET['space_code'] ?? null;

if ($id) {
    // Fetch the space code of the booking
    $space_code_sql = "SELECT space_code FROM parking_bookings WHERE id = $id";
    $space_code_result = $conn->query($space_code_sql);
    $space_code_row = $space_code_result->fetch_assoc();
    $space_code = $space_code_row['space_code'];

    // Delete the booking
    $sql = "DELETE FROM parking_bookings WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Update the space status to 'available'
        $update_sql = "UPDATE parking_spaces SET status = 'available' WHERE space_code = '$space_code'";
        $conn->query($update_sql);
        echo "Booking deleted and space is now available.";
    } else {
        echo "Error deleting booking: " . $conn->error;
    }

} elseif ($space_code) {
    // If only space code is provided (e.g., from space management)
    // Find the booking related to this space code and delete it
    $delete_sql = "DELETE FROM parking_bookings WHERE space_code = '$space_code'";
    if ($conn->query($delete_sql) === TRUE) {
        // Update the space status to 'available'
        $update_sql = "UPDATE parking_spaces SET status = 'available' WHERE space_code = '$space_code'";
        $conn->query($update_sql);
        echo "Booking deleted and space is now available.";
    } else {
        echo "Error deleting booking: " . $conn->error;
    }
}

$conn->close();
echo "<script>window.location.href = 'parking_manage.php';</script>";
?>
