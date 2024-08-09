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
    $full_name = $_POST['full_name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];

    if ($role == 'operational') {
        $stmt = $conn->prepare("INSERT INTO operational_staff (username, password, full_name, contact_number, email, address, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $username, $password, $full_name, $contact_number, $email, $address, $gender);
    } else {
        $stmt = $conn->prepare("INSERT INTO customers (username, password, full_name, contact_number, email, address, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $username, $password, $full_name, $contact_number, $email, $address, $gender);
    }

    if ($stmt->execute()) {
        echo '<p class="success">User created successfully.</p>';
    } else {
        echo '<p class="error">Error: ' . $stmt->error . '</p>';
    }

    $stmt->close();
}

// Fetch and filter operational staff
$staff_search_query = "";
$staff_search_filter = "username";
if (isset($_POST['staff_search'])) {
    $staff_search_query = $_POST['staff_search_query'];
    $staff_search_filter = $_POST['staff_search_filter'];
}

$staff_sql = "SELECT * FROM operational_staff";
if (!empty($staff_search_query)) {
    $staff_sql .= " WHERE $staff_search_filter LIKE '%$staff_search_query%'";
}
$staff_result = $conn->query($staff_sql);

// Fetch and filter customers
$customer_search_query = "";
$customer_search_filter = "username";
if (isset($_POST['customer_search'])) {
    $customer_search_query = $_POST['customer_search_query'];
    $customer_search_filter = $_POST['customer_search_filter'];
}

$customer_sql = "SELECT * FROM customers";
if (!empty($customer_search_query)) {
    $customer_sql .= " WHERE $customer_search_filter LIKE '%$customer_search_query%'";
}
$customer_result = $conn->query($customer_sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3 {
            color: #bb86fc;
            
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-left: auto; 
            margin-right: auto;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        th {
            background-color: #1f1f1f;
        }

        tr:nth-child(even) {
            background-color: #1f1f1f;
        }

        tr:hover {
            background-color: #333;
        }

        a {
            color: #bb86fc;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #333;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #bb86fc;
            color: #121212;
        }

        button {
            background-color: #bb86fc;
            color: #121212;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #7f39fb;
        }

        input[type="text"] {
            background-color: #333;
            color: #ffffff;
            border: 1px solid #555;
            padding: 10px;
            border-radius: 5px;
            /* width: calc(100% - 22px); */
        }

        form p {
            margin: 15px 0;
        }

        h2 {
            margin-bottom: 20px;
            color: #ffffff;
        }

        form {
    display: flex;
    flex-direction: column;
    align-items: left;
    justify-content: center;
    width: 300px;

    
}

h3 {
            color: #bb86fc;
        }

        form {
            background-color: #1f1f1f;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
            width: 600px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        input[type="date"],
        input[type="email"],
        input[type="file"],
        textarea, select {
            
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #333;
            color: #ffffff;
            border: 1px solid #555;
        }

        input[type="file"] {
            padding: 5px;
        }

        textarea {
            height: 100px;
        }

        footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;

    width: 100%;
    bottom: 0;
}

.search-form {
    margin-bottom: 20px;
}

.view-events-container {
        max-width: 1300px;
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        
        }
    </style>
   
</head>
<body>

<!-- HTML form for creating a new user -->
 <div class="view-events-container">
<h2 >Create New User</h2>
    </div>
<div class="form-container">
    
    <form action="manage_users.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="operational">Operational Staff</option>
            <option value="customer">Customer</option>
            
        </select>
        <button type="submit" name="create_user">Create User</button>
    </form>
</div>

    </br>
<div class="view-events-container">
<h2>Operational Staff</h2>
    </div>
<form class="search-form" method="POST" action="manage_users.php">
    <input type="text" name="staff_search_query" placeholder="Search operational staff" value="<?php echo htmlspecialchars($staff_search_query); ?>">
    <select name="staff_search_filter">
        <option value="username" <?php if ($staff_search_filter == 'username') echo 'selected'; ?>>Username</option>
        <option value="full_name" <?php if ($staff_search_filter == 'full_name') echo 'selected'; ?>>Full Name</option>
        <option value="contact_number" <?php if ($staff_search_filter == 'contact_number') echo 'selected'; ?>>Contact Number</option>
    </select>
    <button type="submit" name="staff_search">Search</button>
</form>
<?php
if ($staff_result) {
    if ($staff_result->num_rows > 0) {
        echo '<table>';
        echo '<thead><tr><th>Username</th><th>Full Name</th><th>Contact Number</th><th>Email</th><th>Address</th><th>Gender</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        while ($row = $staff_result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
            echo '<td>' . htmlspecialchars($row['full_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['contact_number']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['address']) . '</td>';
            echo '<td>' . htmlspecialchars($row['gender']) . '</td>';
            echo '<td><a href="edit_user.php?id=' . $row['id'] . '&role=operational">Edit</a> | <a href="delete_user.php?id=' . $row['id'] . '&role=operational" onclick="return confirm(\'Are you sure?\')">Delete</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No operational staff found.</p>';
    }
} else {
    echo '<p class="error">Error executing query: ' . $conn->error . '</p>';
}
?>

</br>
<div class="view-events-container">
<h2>Customers</h2>
</div>
<form class="search-form" method="POST" action="manage_users.php">
    <input type="text" name="customer_search_query" placeholder="Search customers" value="<?php echo htmlspecialchars($customer_search_query); ?>">
    <select name="customer_search_filter">
        <option value="username" <?php if ($customer_search_filter == 'username') echo 'selected'; ?>>Username</option>
        <option value="full_name" <?php if ($customer_search_filter == 'full_name') echo 'selected'; ?>>Full Name</option>
        <option value="contact_number" <?php if ($customer_search_filter == 'contact_number') echo 'selected'; ?>>Contact Number</option>
    </select>
    <button type="submit" name="customer_search">Search</button>
</form>
<?php
if ($customer_result) {
    if ($customer_result->num_rows > 0) {
        echo '<table>';
        echo '<thead><tr><th>Username</th><th>Full Name</th><th>Contact Number</th><th>Email</th><th>Address</th><th>Gender</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        while ($row = $customer_result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
            echo '<td>' . htmlspecialchars($row['full_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['contact_number']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['address']) . '</td>';
            echo '<td>' . htmlspecialchars($row['gender']) . '</td>';
            echo '<td><a href="edit_user.php?id=' . $row['id'] . '&role=customer">Edit</a> | <a href="delete_user.php?id=' . $row['id'] . '&role=customer" onclick="return confirm(\'Are you sure?\')">Delete</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No customers found.</p>';
    }
} else {
    echo '<p class="error">Error executing query: ' . $conn->error . '</p>';
}
?>



<?php include('../partials/footer.php'); ?>