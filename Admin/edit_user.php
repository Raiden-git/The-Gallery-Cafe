<?php include('../partials/menu.php'); ?>


<?php
// edit_user.php

// Include the database connection file
include('db_connect.php');

// Check if user ID is provided
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Convert to integer to prevent SQL injection
    $result = $conn->query("SELECT * FROM users WHERE user_id = $user_id");

    if ($result) {
        $user = $result->fetch_assoc();

        if ($user) {
            echo '<form action="edit_user.php" method="POST">
                <h2>Edit User</h2>
                <input type="hidden" name="user_id" value="' . htmlspecialchars($user['user_id']) . '">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="' . htmlspecialchars($user['username']) . '" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="admin"' . ($user['role'] == 'admin' ? ' selected' : '') . '>Admin</option>
                    <option value="operational"' . ($user['role'] == 'operational' ? ' selected' : '') . '>Operational Staff</option>
                    <option value="customer"' . ($user['role'] == 'customer' ? ' selected' : '') . '>Customer</option>
                </select>
                <button type="submit" name="update_user">Update User</button>
            </form>';
        } else {
            echo '<p>User not found.</p>';
        }
    } else {
        echo '<p>Error executing query: ' . $conn->error . '</p>';
    }
}

// Handle user update
if (isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;
    $role = $_POST['role'];

    if ($password) {
        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $username, $password, $role, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, role = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $username, $role, $user_id);
    }

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: manage_users.php?success=true");
        exit();
    } else {
        echo '<p>Error: ' . $stmt->error . '</p>';
    }
}
?>

<?php include('../partials/footer.php'); ?>