<?php
include('db_connect.php');
include('session_check.php');

$space_code = $_GET['space_code'];

// Delete the parking space
$delete_sql = "DELETE FROM parking_spaces WHERE space_code = '$space_code'";

if ($conn->query($delete_sql) === TRUE) {
    echo "Parking space deleted successfully!";
    echo "<script>window.location.href = 'parking_manage.php';</script>";
} else {
    echo "Error deleting space: " . $conn->error;
}

$conn->close();
?>
