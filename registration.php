<?php
include('admin/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $full_name = $_POST['full_name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];

    // Check if email already exists
    $checkEmailSql = "SELECT * FROM customers WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmailSql);

    if (mysqli_num_rows($result) > 0) {
        // If email exists, show error message and redirect to registration page
        echo "<script>alert('Error: This email is already registered.'); window.location.href = 'registration.html';</script>";
    } else {
        // If email does not exist, insert new user into the database
        $sql = "INSERT INTO customers (username, password, full_name, contact_number, email, address, gender) VALUES ('$user', '$pass', '$full_name', '$contact_number','$email','$address','$gender')";

        if (mysqli_query($conn, $sql)) {
            // If insertion is successful, show success message and redirect to login page
            echo "<script>alert('Registration successful!'); window.location.href = 'login.html';</script>";
        } else {
            // If insertion fails, show error message and redirect to registration page
            echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'registration.html';</script>";
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
