<?php include('../partials/menu.php'); ?>

<?php
include('session_check.php');

// The rest of your page code goes here
?>

    <main>
        <section class="overview">
            <div class="stats-panel">
                <h2>Reservation Stats</h2>
                <p>Upcoming Reservations: <span id="upcoming-reservations">10</span></p>
                <p>Total Reservations: <span id="total-reservations">200</span></p>
                <p>Pending Reservations: <span id="pending-reservations">5</span></p>
            </div>
            <div class="stats-panel">
                <h2>Order Stats</h2>
                <p>Total Orders: <span id="total-orders">150</span></p>
                <p>Pending Orders: <span id="pending-orders">7</span></p>
                <p>Completed Orders: <span id="completed-orders">143</span></p>
            </div>
            <div class="stats-panel">
                <h2>Food Items Stats</h2>
                <p>Total Food Items: <span id="total-food-items">50</span></p>
                <p>Total Categories: <span id="total-categories">10</span></p>
            </div>
            <div class="stats-panel">
                <h2>User Stats</h2>
                <p>Total Users: <span id="total-users">300</span></p>
                <p>Active Users: <span id="active-users">290</span></p>
                <p>Operational Staff: <span id="operational-staff">10</span></p>
            </div>
        </section>
        <section class="quick-links">
            <h2>Quick Links</h2>
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="food_management.php">Food Management</a></li>
                <li><a href="reservation_management.php">Reservation Management</a></li>
                <li><a href="order_management.php">Order Management</a></li>
                <li><a href="settings.php">Website Settings</a></li>
            </ul>
        </section>
    </main>
    
    <?php include('../partials/footer.php'); ?>