<?php
include('db_connect.php');
include('session_check.php');

$new_space_code = $_POST['new_space_code'];

// Insert new parking space
$insert_sql = "INSERT INTO parking_spaces (space_code, status) VALUES ('$new_space_code', 'available')";

if ($conn->query($insert_sql) === TRUE) {
    echo "New parking space added successfully!";
    echo "<script>window.location.href = 'parking_manage.php';</script>";
} else {
    echo "Error adding space: " . $conn->error;
}

$conn->close();
?>
