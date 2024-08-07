
<?php include('admin/db_connect.php')?>
<?php

// Get form data
$customer_name = $_POST['customer_name'];
$reservation_date = $_POST['reservation_date'];
$number_of_guests = $_POST['number_of_guests'];
$email = $_POST['email'];
$contact_number = $_POST['contact_number'];

// Insert reservation into database
$sql = "INSERT INTO reservations (customer_name, reservation_date, number_of_guests, email, contact_number, status)
VALUES ('$customer_name', '$reservation_date', '$number_of_guests', '$email', '$contact_number', 'Pending')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Product updated successfully!'); window.location.href = 'customer_dashboard.php';</script>";
} else {
    echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'customer_dashboard.php';</script>";
}

$conn->close();
?>
