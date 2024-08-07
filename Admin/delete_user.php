<?php
include('db_connect.php');
include('session_check.php');

$id = $_GET['id'];
$role = $_GET['role'];

if ($role == 'operational') {
    $stmt = $conn->prepare("DELETE FROM operational_staff WHERE id = ?");
} else {
    $stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
}
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo '<p class="success">User deleted successfully.</p>';
} else {
    echo '<p class="error">Error: ' . $stmt->error . '</p>';
}

$stmt->close();
$conn->close();

header("Location: manage_users.php");
exit;
?>
