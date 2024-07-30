<?php include('../partials/menu.php'); ?>


<?php
// Include the database connection file
include('db_connect.php');
include('session_check.php');

// Check if the connection is active
if (!$conn->ping()) {
    die('Connection is not active.');
}

// Check if the ID and role are provided
if (!isset($_GET['id']) || !isset($_GET['role'])) {
    die('ID or role not specified.');
}

$id = intval($_GET['id']);
$role = $_GET['role'];
$table = ($role == 'operational') ? 'operational_staff' : 'customers';

// Handle form submission for updating user details
if (isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    
    $password = null;
    if (isset($_POST['change_password']) && !empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    }

    if ($password) {
        $stmt = $conn->prepare("UPDATE $table SET username=?, full_name=?, contact_number=?, email=?, address=?, gender=?, password=? WHERE id=?");
        $stmt->bind_param("sssssssi", $username, $full_name, $contact_number, $email, $address, $gender, $password, $id);
    } else {
        $stmt = $conn->prepare("UPDATE $table SET username=?, full_name=?, contact_number=?, email=?, address=?, gender=? WHERE id=?");
        $stmt->bind_param("ssssssi", $username, $full_name, $contact_number, $email, $address, $gender, $id);
    }

    if ($stmt->execute()) {
        echo '<p>User updated successfully.</p>';
    } else {
        echo '<p>Error: ' . $stmt->error . '</p>';
    }

    $stmt->close();
}

// Fetch the current user details
$stmt = $conn->prepare("SELECT * FROM $table WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('User not found.');
}

$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit User</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
        height: 100vh;
    }
    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 95%
        
    }
    h2 {
        margin-bottom: 20px;
        color: #333;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    input[type="text"], input[type="email"], input[type="password"], select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    input[type="checkbox"] {
        margin-bottom: 15px;
    }
    button {
        width: 100%;
        padding: 10px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background-color: #218838;
    }
</style>
</head>
<body>

<div class="container">
    <form action="edit_user.php?id=<?php echo $id; ?>&role=<?php echo $role; ?>" method="POST" onsubmit="return validatePassword()">
        <h2>Edit User</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
        
        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($user['contact_number']); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
        
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male" <?php if ($user['gender'] == 'male') echo 'selected'; ?>>Male</option>
            <option value="female" <?php if ($user['gender'] == 'female') echo 'selected'; ?>>Female</option>
        </select>
        
        <label for="change_password">Change Password:</label>
        <input type="checkbox" id="change_password" name="change_password" onclick="togglePasswordField()">
        
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" disabled>
        
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" disabled>
        
        <button type="submit" name="update_user">Update User</button>
    </form>
</div>

<script>
function togglePasswordField() {
    var passwordField = document.getElementById("password");
    var confirmPasswordField = document.getElementById("confirm_password");
    if (document.getElementById("change_password").checked) {
        passwordField.disabled = false;
        confirmPasswordField.disabled = false;
    } else {
        passwordField.value = "";
        confirmPasswordField.value = "";
        passwordField.disabled = true;
        confirmPasswordField.disabled = true;
    }
}

function validatePassword() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;
    if (document.getElementById("change_password").checked && password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }
    return true;
}
</script>



<?php include('../partials/footer.php'); ?>