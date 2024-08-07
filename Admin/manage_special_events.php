<?php include('../partials/menu.php'); ?>

<?php

include('db_connect.php');
include('session_check.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];

    // Retrieve and process the image file
    $image = $_FILES['image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));

    // Insert new event into the database
    $sql = "INSERT INTO special_events (name, description, date, location, image) VALUES ('$name', '$description', '$date', '$location', '$imgContent')";

    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Event added successfully!'); window.location.href = 'manage_special_events.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'manage_special_events.php';</script>";
    }
}

// Query to select events
$sql = "SELECT id, name, description, date, location, image FROM special_events";
$result = mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function validateEventForm() {
            var name = document.getElementById('name').value;
            var description = document.getElementById('description').value;
            var date = document.getElementById('date').value;
            var location = document.getElementById('location').value;
            var image = document.getElementById('image').value;

            if (name == "") {
                alert("Event name must be filled out");
                return false;
            }
            if (description == "") {
                alert("Event description must be filled out");
                return false;
            }
            if (date == "") {
                alert("Event date must be filled out");
                return false;
            }
            if (location == "") {
                alert("Event location must be filled out");
                return false;
            }
            if (image == "") {
                alert("Event image must be selected");
                return false;
            }
            return true;
        }

        function searchEvents() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var table = document.getElementById('eventsTable');
            var tr = table.getElementsByTagName('tr');

            for (var i = 1; i < tr.length; i++) {
                tr[i].style.display = 'none';
                var td = tr[i].getElementsByTagName('td');
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = '';
                            break;
                        }
                    }
                }
            }
        }


    </script>

    <style>
        .logout {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .logout a {
            text-decoration: none;
            color: white;
            background-color: #ff4b4b;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .logout a:hover {
            background-color: #ff0000;
        }

        .view-events-container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        img {
            width: 200px;
            height: 150px;
            object-fit: cover;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: left;
            justify-content: center;
            width: 300px;
        }
    </style>
</head>
<body>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <h3>Add New Event</h3>
    <form action="manage_special_events.php" method="post" enctype="multipart/form-data" onsubmit="return validateEventForm()">

        <label for="name">Event Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Event Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        <button type="submit">Add Event</button>
    </form>
    <br>


    <div class="view-events-container">
        <h2>Available Events</h2>
        <input type="text" id="searchInput" onkeyup="searchEvents()" placeholder="Search for events..">
        <table id="eventsTable">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Location</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            // Check if there are any events in the result
            if (mysqli_num_rows($result) > 0) {
                // Fetch and display each event
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['location'] . "</td>";
                    echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Event Image"/></td>';
                    echo '<td>';
                    echo '<a href="edit_event.php?id=' . $row['id'] . '">Edit</a> | ';
                    echo '<a href="delete_event.php?id=' . $row['id'] . '" onclick="return confirm(\'Are you sure you want to delete this event?\')">Delete</a>';
                    echo "</tr>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No events found</td></tr>";
            }
            // Close the database connection
            /* mysqli_close($conn); */
            ?>
        </table>
    </div>
</body>
</html>

