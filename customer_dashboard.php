<?php
// Start the session
session_start();

// Check if the user is logged in as customer
if (!isset($_SESSION['username'])) {
    // If not logged in as customer, redirect to login page
    header("Location: index.html");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Café</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="customer_dashboard.css">

    </head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">The Gallery Café</div>
            <ul class="nav-menu">
                <li><a href="customer_dashboard.php">Home</a></li>
                <li><a href="view_products_customer.php">Menu</a></li>
                <li><a href="special_events.php">Special Events</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
            </ul>

            <a href="profile.php" class="profile">Hi, <?php echo ($username); ?></a>

            <div class="nav-buttons">
                <a class="logout" href="logout.php">Logout</a>
            </div>

        </nav>
    </header>



    <section class="hero text-center" aria-label="home" id="home">

        <ul class="hero-slider" data-hero-slider>

          <li class="slider-item active" data-hero-slider-item>

            <div class="slider-bg">
              <img src="img/hero-slider-1.jpg" width="1880" height="950" alt="" class="img-cover">
            </div>


            <p class="label-2 section-subtitle slider-reveal">Tradational & Hygine</p>

            <h1 class="display-1 hero-title slider-reveal">
              For the love of <br>
              delicious food
            </h1>

            <p class="body-2 hero-text slider-reveal">
              Come with family & feel the joy of mouthwatering food
            </p>

            <a href="#" class="btn btn-primary slider-reveal">
              <span class="text text-1">View Our Menu</span>

              <span class="text text-2" aria-hidden="true">View Our Menu</span>
            </a>

          </li>

          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="img/hero-slider-2.jpg" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">delightful experience</p>

            <h1 class="display-1 hero-title slider-reveal">
              Flavors Inspired by <br>
              the Seasons
            </h1>

            <p class="body-2 hero-text slider-reveal">
              Come with family & feel the joy of mouthwatering food
            </p>

            <a href="#" class="btn btn-primary slider-reveal">
              <span class="text text-1">View Our Menu</span>

              <span class="text text-2" aria-hidden="true">View Our Menu</span>
            </a>

          </li>

          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="img/hero-slider-3.jpg" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">amazing & delicious</p>

            <h1 class="display-1 hero-title slider-reveal">
              Where every flavor <br>
              tells a story
            </h1>

            <p class="body-2 hero-text slider-reveal">
              Come with family & feel the joy of mouthwatering food
            </p>

            <a href="view_products_customer.php" class="btn btn-primary slider-reveal">
              <span class="text text-1">View Our Menu</span>

              <span class="text text-2" aria-hidden="true">View Our Menu</span>
            </a>

          </li>

        </ul>

        <a href="#reservation" class="hero-btn has-after">
          <img src="img/hero-icon.png" width="48" height="48" alt="booking icon">

          <span class="label-2 text-center span">Book A Table</span>
        </a>

      </section>

      
      <!-- 
        - #ABOUT
      -->

      <section class="section about text-center" aria-labelledby="about-label" id="about">
        <div class="container">

          <div class="about-content">

            <p class="label-2 section-subtitle" id="about-label">Our Story</p>

            <h2 class="headline-1 section-title">Every Flavor Tells a Story</h2>

            <p class="section-text">
            Nestled in the vibrant heart of Colombo, The Gallery Café is a unique destination that seamlessly blends exquisite dining with an artistic ambiance. Housed in a historic building that once served as the office of renowned architect Geoffrey Bawa, the café exudes an air of elegance and creativity. With its art-filled interiors, tranquil courtyard, and a menu that features a fusion of international and Sri Lankan cuisines, The Gallery Café offers an unforgettable experience for both locals and visitors.
            </p>

            <div class="contact-label">Book Through Call</div>

            <a href="tel:+94728899044" class="body-1 contact-number hover-underline">+94 72 88 99 044</a>

          </div>

          <figure class="about-banner">

            <img src="img/about-banner.jpg" width="570" height="570" loading="lazy" alt="about banner"
              class="w-100" data-parallax-item data-parallax-speed="1">

            <div class="abs-img abs-img-1 has-before" data-parallax-item data-parallax-speed="1.75">
              <img src="img/about-abs-image.jpg" width="285" height="285" loading="lazy" alt=""
                class="w-100">
            </div>

            <div class="abs-img abs-img-2 has-before">
              <img src="img/badge-2.png" width="133" height="134" loading="lazy" alt="">
            </div>

          </figure>

          <img src="img/shape-3.png" width="197" height="194" loading="lazy" alt="" class="shape">

        </div>
      </section>


      <section class="section menu" aria-label="menu-label" id="menu">
        <div class="container">
            <p class="section-subtitle text-center label-2">Special Selection</p>
            <h2 class="headline-1 section-title text-center">Delicious Menu</h2>
            
            
              <?php include('admin/db_connect.php')?>
              <?php
              // Fetch menu items
              $sql = "SELECT name, description, price, category, image FROM featured_menu";
              $result = $conn->query($sql);

              if (mysqli_num_rows($result) > 0) {
                // Loop through each product and display it
                while ($row = mysqli_fetch_assoc($result)) {

                    echo '<div class="menu-card">';
                    echo '<img class="card-banner img-holder" width="150px" height="100px" src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Product Image"/>';
                    echo '<h3 class="title-3">' . $row['name'] . '</h3>';
                    echo '<p class="card-text label-1">' . $row['description'] . '</p>';
                    echo '<p class="span title-2">Rs.' . $row['price'] . '</p>';
                    
                    echo '</form>';
                    echo '</div>';
                }
              } else {
                // Display a message if no products are available
                echo '<p>No products available.</p>';
              }

              $conn->close();
              ?>
            </ul>
            <p class="menu-text text-center">
                During winter daily from <span class="span">7:00 pm</span> to <span class="span">9:00 pm</span>
            </p>
            <a href="view_products_customer.php" class="btn btn-primary">
                <span class="text text-1">View All Menu</span>
                <span class="text text-2" aria-hidden="true">View All Menu</span>
            </a>
            <img src="img/shape-5.png" width="921" height="1036" loading="lazy" alt="shape" class="shape shape-2 move-anim">
            <img src="img/shape-6.png" width="343" height="345" loading="lazy" alt="shape" class="shape shape-3 move-anim">
        </div>
    </section>


    <div id="#promo"></div>

    <section class="section menu" aria-label="menu-label" >
        <div class="container">
            <p class="section-subtitle text-center label-2">Special Offers</p>
            <h2 class="headline-1 section-title text-center">Promotions</h2>
            
            
              <?php include('admin/db_connect.php')?>
              <?php
              // Fetch menu items
              $sql = "SELECT name, description, price, date, image FROM promotions";
              $result = $conn->query($sql);

              if (mysqli_num_rows($result) > 0) {
                // Loop through each product and display it
                while ($row = mysqli_fetch_assoc($result)) {

                    echo '<div class="menu-card">';
                    echo '<img class="card-banner img-holder" width="150px" height="100px" src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Product Image"/>';
                    echo '<h3 class="title-3">' . $row['name'] . '</h3>';
                    echo '<p class="card-text label-1">' . $row['description'] . '</p>';
                    echo '<p class="card-text label-1">' . $row['date'] . '</p>';
                    echo '<p class="span title-2">Rs.' . $row['price'] . '</p>';
                    
                    echo '</form>';
                    echo '</div>';
                }
              } else {
                // Display a message if no products are available
                echo '<p>No products available.</p>';
              }

              $conn->close();
              ?>
            </ul>
            
            <img src="img/shape-5.png" width="921" height="1036" loading="lazy" alt="shape" class="shape shape-2 move-anim">
            <img src="img/shape-6.png" width="343" height="345" loading="lazy" alt="shape" class="shape shape-3 move-anim">
        </div>
    </section>


<!-- reservation -->


    <div class="bktable" id="reservation">
        <h2>Table Reservation</h2>
        <form action="process_reservation.php" method="post">
            <label for="customer_name">Full Name: (Enter your full name entered in the system)</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="reservation_date">Booking Date and Time:</label>
            <input type="datetime-local" id="reservation_date" name="reservation_date" required>

            <label for="number_of_guests">Number of Guests:</label>
            <input type="number" id="number_of_guests" name="number_of_guests" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="contact_number">Contact Number:</label>
            <input type="tel" id="contact_number" name="contact_number" required>

            <input type="submit" value="Book Table"> 

        </form>
    </div>


      <!-- 
    - #FOOTER
  -->

  <footer class="footer section has-bg-image text-center" style="background-image: url('img/footer-bg.jpg')">
        <div class="container">
    
          <div class="footer-top grid-list">
    
            <div class="footer-brand has-before has-after">
    
    
              
              <a href="#" class="logo">
                <div class="footer-logo-name">The Gallery Café</div>
              </a>
    
              <address class="body-4">
                ABC Road, Colombo
              </address>
    
              <a href="thegallery@cafe.lk" class="body-4 contact-link">thegallery@cafe.lk</a>
    
              <a href="tel:+94728899044" class="body-4 contact-link">Booking Request : +94 72 88 99 044</a>
    
              <p class="body-4">
                Open : 08:00 am - 07:00 pm
              </p>
    
              <div class="wrapper">
                <div class="separator"></div>
                <div class="separator"></div>
                <div class="separator"></div>
              </div>
            </br>
              <a href="terms.php" class="label-2 footer-link hover-underline">Terms and Conditions</a>
               <a href="privacy.php" class="label-2 footer-link hover-underline">Privacy Policy</a>
            </div>
    
            <ul class="footer-list">
    
              <li><a href="#" class="label-2 footer-link hover-underline">Home</a></li>
              <li><a href="#" class="label-2 footer-link hover-underline">Menus</a></li>
              <li><a href="#" class="label-2 footer-link hover-underline">Special Events</a></li>
              <li><a href="#" class="label-2 footer-link hover-underline">Contact us</a></li>

            </ul>
    
            <ul class="footer-list">
    
              <li>
                <a href="#" class="label-2 footer-link hover-underline">Facebook</a>
              </li>
    
              <li>
                <a href="#" class="label-2 footer-link hover-underline">Instagram</a>
              </li>
    
              <li>
                <a href="#" class="label-2 footer-link hover-underline">Twitter</a>
              </li>
    
              <li>
                <a href="#" class="label-2 footer-link hover-underline">Youtube</a>
              </li>
    
              <li>
                <a href="#" class="label-2 footer-link hover-underline">Google Map</a>
              </li>
    
            </ul>
    
          </div>
    
          <div class="footer-bottom">
    
            <p class="copyright">
              © 2024 The Gallery Café. All Rights Reserved
            </p>
          

          </div>
    
        </div>
      </footer>




      <script src="script.js"></script>
      <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
