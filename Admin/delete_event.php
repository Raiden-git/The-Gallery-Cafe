<?php
include('db_connect.php');
include('session_check.php');

// Check if the id is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM special_events WHERE id='$id'";

    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Event deleted successfully!'); window.location.href = 'manage_special_events.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'manage_special_events.php';</script>";
    }
} else {
    header("Location: manage_special_events.php");
    exit();
}
?>
