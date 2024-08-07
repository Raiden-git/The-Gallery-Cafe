<?php
include('db_connect.php');
include('session_check.php');

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Product Updated successfully!'); window.location.href = 'admin_dashboard.php';</script>";
} else {
    echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'admin_dashboard.php';</script>";
}

$stmt->close();
$conn->close();
?>
