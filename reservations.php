<?php
// Include the database connection file
include('Admin/db_connect.php');
session_start(); // Start the session

// Initialize variables
$name = $email = $phone = $date = $time = $guests = "";
$name_err = $email_err = $phone_err = $date_err = $time_err = $guests_err = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate phone
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter your phone number.";
    } elseif (!preg_match('/^[0-9]{10}$/', trim($_POST["phone"]))) {
        $phone_err = "Please enter a valid 10-digit phone number.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    // Validate date
    if (empty(trim($_POST["date"]))) {
        $date_err = "Please select a date.";
    } else {
        $date = trim($_POST["date"]);
    }

    // Validate time
    if (empty(trim($_POST["time"]))) {
        $time_err = "Please select a time.";
    } else {
        $time = trim($_POST["time"]);
    }

    // Validate guests
    if (empty(trim($_POST["guests"]))) {
        $guests_err = "Please enter the number of guests.";
    } elseif (!ctype_digit(trim($_POST["guests"]))) {
        $guests_err = "Please enter a valid number.";
    } else {
        $guests = trim($_POST["guests"]);
    }

    // Check for errors before inserting in database
    if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($date_err) && empty($time_err) && empty($guests_err)) {
        // Prepare an insert statement
        $stmt = $conn->prepare("INSERT INTO reservations (name, email, phone, date, time, guests) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $name, $email, $phone, $date, $time, $guests);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Reservation made successfully.';
            header("Location: reservations.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Reservation - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Make a Reservation</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="reservations.php">Reservations</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- Display message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message success">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <form action="reservations.php" method="POST">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                <span class="error"><?php echo $name_err; ?></span>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                <span class="error"><?php echo $phone_err; ?></span>
            </div>
            <div>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>">
                <span class="error"><?php echo $date_err; ?></span>
            </div>
            <div>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($time); ?>">
                <span class="error"><?php echo $time_err; ?></span>
            </div>
            <div>
                <label for="guests">Number of Guests:</label>
                <input type="text" id="guests" name="guests" value="<?php echo htmlspecialchars($guests); ?>">
                <span class="error"><?php echo $guests_err; ?></span>
            </div>
            <div>
                <button type="submit">Make Reservation</button>
            </div>
        </form>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> The Gallery Café. All rights reserved.</p>
    </footer>
</body>
</html>
