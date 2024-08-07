<?php include('admin/db_connect.php')?>

<?php
// Fetch menu items
$sql = "SELECT name, description, price, category, image FROM featured_menu";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<li>
                <div class="menu-card hover:card">
                    <figure class="card-banner img-holder" style="--width: 100; --height: 100;">
                        <img src="'.$row["image"].'" width="100" height="100" loading="lazy" alt="'.$row["name"].'" class="img-cover">
                    </figure>
                    <div>
                        <div class="title-wrapper">
                            <h3 class="title-3">
                                <a href="#" class="card-title">'.$row["name"].'</a>
                            </h3>
                            <span class="badge label-1">'.$row["category"].'</span>
                            <span class="span title-2">Rs. '.$row["price"].'</span>
                        </div>
                        <p class="card-text label-1">
                            '.$row["description"].'
                        </p>
                    </div>
                </div>
            </li>';
    }
} else {
    echo "0 results";
}

$conn->close();
?>
