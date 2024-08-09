<?php include('../partials/menu.php'); ?>
<?php
// admin_dashboard.php
include('db_connect.php');
include('session_check.php');

// Fetch all parking spaces
$spaces_sql = "SELECT * FROM parking_spaces";
$spaces_result = $conn->query($spaces_sql);

// Fetch all bookings
$bookings_sql = "SELECT * FROM parking_bookings";
$bookings_result = $conn->query($bookings_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            width: 90%;
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

        .add_space{
            display:inline-flex;

            position: relative;
            left:34%;
        }

        footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;

    width: 100%;
    bottom: 0;
}
    </style>
</head>
<body>

<!-- Manage Parking Spaces Section -->

<table>
<h2>Manage Parking Spaces</h2>
    <tr>
        <th>Space Code</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while($row = $spaces_result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['space_code'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <?php if($row['status'] === 'available'): ?>
                <a href="admin_book_space.php?space_code=<?= $row['space_code'] ?>">Book</a>
                <a href="admin_delete_space.php?space_code=<?= $row['space_code'] ?>">Delete Space</a>
            <?php else: ?>
                <a href="admin_delete_booking.php?space_code=<?= $row['space_code'] ?>">Delete Booking</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
            </br> </br>
<div class="add_space">

<form action="admin_add_space.php" method="POST">
    <p>
        <h3>Add New Parking Space</h3>
        <label for="new_space_code">Space Code:</label>
        <input type="text" id="new_space_code" name="new_space_code" required>
        <button type="submit">Add Space</button>
    </p>
    
</form>
</div>

<!-- Manage Bookings Section -->
<h2>All Bookings</h2>
<table>
    <tr>
        <th>Customer Name</th>
        <th>Contact Number</th>
        <th>Space Code</th>
        <th>Booking Start</th>
        <th>Booking End</th>
        <th>Action</th>
    </tr>
    <?php while($row = $bookings_result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['customer_name'] ?></td>
        <td><?= $row['contact_number'] ?></td>
        <td><?= $row['space_code'] ?></td>
        <td><?= $row['booking_time_start'] ?></td>
        <td><?= $row['booking_time_end'] ?></td>
        <td>
            <a href="admin_edit_booking.php?id=<?= $row['id'] ?>">Edit</a>
            <a href="admin_delete_booking.php?id=<?= $row['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
<?php include('../partials/footer.php'); ?>