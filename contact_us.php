

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
    <title>Contact Us - The Gallery Café</title>
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #121212;
            color: #e0e0e0;
        }

        header {
    width: 100%;
    background-color: #333;
    padding: 10px 0;
}

.navbar {
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
}

.logo {
    position: relative;
   color: white; 
   font-size: 50px; 
   font-family: Italianno;
   font-weight: 400;
   top: 0px;
   left: 40px;
}

.nav-menu {
    list-style: none;
    display: flex;
    gap: 20px;
    margin: 0;
    padding: 0;
}

.nav-menu li {
    display: inline;
}

.nav-menu a {
    color: #fff;
    text-decoration: none;
    font-size: 1em;
}

.nav-buttons {
    display: flex;
    gap: 10px;
}

.profile {
  position: relative;
  left: 50px;
  text-decoration: none;
  color:white;
  background-color: #333;
  border: 1px solid hsl(38, 61%, 73%);
  border-radius: 20px;
  padding: 10px 20px;
  font-size: 16px;
  margin: 5px;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.profile:hover {
  color: hsl(38, 61%, 73%);
}

.logout {
  position: relative;
  left: 55px;
  text-decoration: none;
  background-color: hsl(38, 61%, 73%);
  padding: 8px 17px;
  color: black;
  border: 1px solid hsl(38, 61%, 73%);
  font-size: 16px;
  margin: 5px;
  transition: background-color 0.3s ease, color 0.3s ease;
}




        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #1e1e1e;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        h1 {
            color: #ffffff;
        }
        .contact-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .left-side {
            flex: 1 1 45%;
            padding-right: 20px;

        }
        .contact-info, .form-container {
            padding: 20px;
            background-color: #2c2c2c;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            margin-bottom: 20px;
            border: 1px solid hsl(38, 61%, 73%);
        }
        .contact-info h2, .form-container h2 {
            margin-bottom: 10px;
            color: #e0e0e0;
        }
        .contact-info p {
            margin: 5px 0;
            
        }
        .contact-info a {
            color: #81c784;
            text-decoration: none;
        }
        .contact-info .social-links {
            margin-top: 20px;
        }
        .contact-info .social-links a {
            color: #e0e0e0;
            text-decoration: none;
            margin-right: 15px;
        }
        .contact-info .social-links a:hover {
            color: #81c784;
        }
        .contact-info .social-links i {
            font-size: 1.5em;
        }
        .map {
            flex: 1 1 45%;
            margin-bottom: 20px;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 95%;
            padding: 10px;
            border: 1px solid hsl(30, 13%, 91%);
            background-color: #333;
            color: #e0e0e0;
        }
        .form-group button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #33333365;
            color: #fff;
            border: 1px solid hsl(38, 61%, 73%);
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: hsl(38, 61%, 73%);
            color: #121212;
        }

        .footer-bottom{
            display: flex;
            justify-content:center;
            align-items:center;
            padding:20px;
            background-color: #333;
        }

    </style>
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

            <a class="profile" href="profile.php">Profile</a>

            <div class="nav-buttons">
                <a class="logout" href="logout.php">Logout</a>
            </div>

        </nav>
    </header>

    <div class="container">
        <h1>Contact Us</h1>
        <div class="contact-container">
            <div class="left-side">
                <div class="contact-info">
                    <h2>Phone</h2>
                    <p>+94 72 88 99 044</p>
                    <p>+94 75 01 41 666</p>
                    <h2>Email</h2>
                    <p><a href="mailto:thegallery@cafe.lk">thegallery@cafe.lk</a></p>
                    <h2>Address</h2>
                    <p>2 Alfred House Rd, Colombo</p>

                    <h2>Follow us on</h2>
                    <div class="social-links">
                        <a href="https://www.facebook.com/yourpage" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/yourprofile" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.youtube.com/channel/yourchannel" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </br>
                    <a href="terms.php" class="label-2 footer-link hover-underline">Terms and Conditions</a>
                </br>
                    <a href="privacy.php" class="label-2 footer-link hover-underline">Privacy Policy</a>
                </div>
                <div class="form-container">
                    <h2>Contact Form</h2>
                    <form action="contact_form_handler.php" method="POST">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15843.726643750857!2d79.8548722!3d6.898777!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259602cb3bc09%3A0x677419394138f674!2sThe%20Gallery%20Caf%C3%A9!5e0!3m2!1sen!2slk!4v1722834527965!5m2!1sen!2slk" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

<footer>

    <div class="footer-bottom">
    
    <p class="copyright">
      © 2024 The Gallery Café. All Rights Reserved
    </p>

  </div>
</footer>

</body>

</html>
