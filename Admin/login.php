<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists in the database
    $stmt = $conn->prepare('SELECT id, username, password FROM admins WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        if (md5($password) === $hashed_password) {
            // Password is correct
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_username'] = $username;
            header('Location: dashboard.php');
            exit;
        } else {
            // Incorrect password
            $error = "Incorrect username or password.";
        }
    } else {
        // Username not found
        $error = "Incorrect username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head> 
<body>
    <div class="login-container">
        <form action="login.php" method="post" class="login-form">
            <h2>Admin Login</h2>
            <?php if (isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
