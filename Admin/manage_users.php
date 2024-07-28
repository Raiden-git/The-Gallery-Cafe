<?php include('../partials/menu.php'); ?>



<?php


// Include the database connection file
include('db_connect.php');


include('session_check.php');



// Check if the connection is active
if (!$conn->ping()) {
    die('Connection is not active.');
}

// Handle user creation
if (isset($_POST['create_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        echo '<p>User created successfully.</p>';
    } else {
        echo '<p>Error: ' . $stmt->error . '</p>';
    }

    $stmt->close();
}

// Fetch existing users
$result = $conn->query("SELECT * FROM users");

if ($result) {
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<thead><tr><th>Username</th><th>Role</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
            echo '<td>' . htmlspecialchars($row['role']) . '</td>';
            echo '<td><a href="edit_user.php?id=' . $row['user_id'] . '">Edit</a> | <a href="delete_user.php?id=' . $row['user_id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No users found.</p>';
    }
} else {
    echo '<p>Error executing query: ' . $conn->error . '</p>';
}

// Close connection
$conn->close();
?>

<!-- HTML form for creating a new user -->
<form action="manage_users.php" method="POST">
    <h2>Create New User</h2>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <label for="role">Role:</label>
    <select id="role" name="role" required>
        <option value="operational">Operational Staff</option>
        <option value="customer">Customer</option>
    </select>
    <button type="submit" name="create_user">Create User</button>
</form>

<?php include('../partials/footer.php'); ?>