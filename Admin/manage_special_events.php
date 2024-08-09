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
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .view-events-container {
        max-width: 1300px;
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        
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
            color: #ffffff;
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
        input[type="number"],
        input[type="date"],
        input[type="file"],
        textarea {
            width: calc(100% - 22px);
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

        .manage{
            display: flex;
            justify-content: space-around;
            width: 50%;
            margin-top: 20px;
        }
        
        .manage a{
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #333;
            color: #bb86fc;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        img {
            width: 200px;
            height: 150px;
            object-fit: cover;
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
<div class="view-events-container">
    <h3 >Add New Event</h3>
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
</div>

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
    <?php include('../partials/footer.php'); ?>

