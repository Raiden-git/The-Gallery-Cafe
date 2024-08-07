<?php
include('db_connect.php');
include('session_check.php');

// Check if the id is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM promotions WHERE id='$id'";

    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Promotion deleted successfully!'); window.location.href = 'promotions.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'promotions.php';</script>";
    }
} else {
    header("Location: promotions.php");
    exit();
}
?>
