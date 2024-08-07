<?php include('../partials/menu.php'); ?>
<?php
include('db_connect.php');
include('session_check.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    
    // Check if a new image is uploaded
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
        $sql = "UPDATE special_events SET name='$name', description='$description', date='$date', location='$location', image='$imgContent' WHERE id='$id'";
    } else {
        $sql = "UPDATE special_events SET name='$name', description='$description', date='$date', location='$location' WHERE id='$id'";
    }
    
    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Special event updated successfully!'); window.location.href = 'special_events.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'special_events.php';</script>";
    }
}

// Check if the id is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM special_events WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $event = mysqli_fetch_assoc($result);
    mysqli_close($conn);
} else {
    header("Location: special_events.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Special Event</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <h3>Edit Special Event</h3>
    <form action="edit_event.php" method="post" enctype="multipart/form-data" onsubmit="return validateEventForm()">
        <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
        <label for="name">Event Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $event['name']; ?>" required>

        <label for="description">Event Description:</label>
        <textarea id="description" name="description" required><?php echo $event['description']; ?></textarea>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $event['date']; ?>" required>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo $event['location']; ?>" required>

        <img src="data:image/jpeg;base64,<?php echo base64_encode($promotion['image']); ?>" alt="Promotion Image" width="100">
        <input type="file" id="image" name="image" accept="image/*">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($event['image']); ?>" alt="Event Image" width="100">

        <button type="submit">Update Event</button>
    </form>
</body>
</html>


