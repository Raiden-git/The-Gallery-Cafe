<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Booking System</title>
    <style>
        .parking-space {
            width: 50px;
            height: 50px;
            margin: 5px;
            display: inline-block;
            text-align: center;
            line-height: 50px;
            color: white;
            cursor: pointer;
        }
        .available { background-color: green; }
        .booked { background-color: red; }
        #bookingForm { display: none; }
    </style>
</head>
<body>

<h1>Parking Booking System</h1>

<div id="parkingLot">
    <?php
    $conn = new mysqli('localhost', 'root', '', 'gallery_cafe');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM parking_spaces";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $class = ($row['status'] == 'available') ? 'available' : 'booked';
            echo "<div class='parking-space $class' data-space='{$row['space_code']}'>{$row['space_code']}</div>";
        }
    }

    $conn->close();
    ?>
</div>

<div id="bookingForm">
    <h2>Book Parking Space</h2>
    <form action="book_space.php" method="POST">
        <input type="hidden" id="spaceCode" name="space_code" readonly>
        <p>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </p>
        <p>
            <label for="contact">Contact Number:</label>
            <input type="text" id="contact" name="contact_number" required>
        </p>
        <p>
            <label for="start">Booking Start Time:</label>
            <input type="datetime-local" id="start" name="booking_time_start" required>
        </p>
        <p>
            <label for="end">Booking End Time:</label>
            <input type="datetime-local" id="end" name="booking_time_end" required>
        </p>
        <button type="submit">Book Now</button>
    </form>
</div>

<script>
    document.querySelectorAll('.available').forEach(function(space) {
        space.addEventListener('click', function() {
            document.getElementById('spaceCode').value = space.dataset.space;
            document.getElementById('bookingForm').style.display = 'block';
        });
    });
</script>

</body>
</html>
