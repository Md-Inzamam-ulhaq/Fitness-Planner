<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$success_msg = '';
if (isset($_SESSION['success_msg'])) {
    $success_msg = $_SESSION['success_msg'];
    unset($_SESSION['success_msg']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Planner - Home</title>
    <link rel="stylesheet" href="home.css">
    <script src="https://kit.fontawesome.com/97ebdf5864.js" crossorigin="anonymous"></script>
    <style>
        .alert-msg {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50; /* Green background */
            color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="nav__logo">
            <a href="#"><img src="logo.png" alt="Logo"></a>
        </div>
        <ul class="nav__links">
            <li class="link"><a href="home.php">Home</a></li>
            <li class="link"><a href="planner.php">Planner</a></li>
            <li class="link"><a href="#">Service</a></li>
            <li class="link"><a href="profile.php">Profile</a></li>
            <li class="link"><a href="#">Community</a></li>
        </ul>
        <a href="logout.php"><button class="btn">Logout</button></a>
    </nav>

    <!-- Alert Message -->
    <?php if ($success_msg): ?>
        <div class="alert-msg" id="alert-msg"><?php echo $success_msg; ?></div>
        <script>
            // Show the alert message
            document.getElementById('alert-msg').style.display = 'block';
            
            // Automatically hide the alert message after 3 seconds
            setTimeout(function() {
                document.getElementById('alert-msg').style.display = 'none';
            }, 3000);
        </script>
    <?php endif; ?>

    <!-- Header Section -->
    <header class="section__container header__container">
        <div class="header__content">
            <span class="bg__blur"></span>
            <span class="bg__blur header__blur"></span>
            <h4>BEST FITNESS WEBSITE</h4>
            <h1><span>SHAPE</span> YOUR BODY</h1>
            <p>
                Unleash your potential and embark on a journey towards a stronger,
                fitter, and more confident you. Sign up for 'Shape Your Body' now
                and witness the incredible transformation your body is capable of!
            </p>
            <a href="planner.php"><button class="btn">Get Started</button></a>
        </div>
        <div class="header__image">
            <img src="header.png" alt="Header Image">
        </div>
    </header>

    <!-- Explore Programs Section -->
    <section class="section__container explore__container">
        <div class="explore__header">
            <h2 class="section__header">EXPLORE OUR PROGRAM</h2>
            <div class="explore__nav">
                <span><i class="ri-arrow-left-line"></i></span>
                <span><i class="ri-arrow-right-line"></i></span>
            </div>
        </div>
        <div class="explore__grid">
            <div class="explore__card">
                <span><i class="ri-boxing-fill"></i></span>
                <h4>Strength</h4>
                <p>
                    Embrace the essence of strength as we delve into its various
                    dimensions: physical, mental, and emotional.
                </p>
                <a href="#">Learn More<i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="explore__card">
                <span><i class="ri-heart-pulse-fill"></i></span>
                <h4>Physical Fitness</h4>
                <p>
                    It encompasses activities that improve health, strength,
                    flexibility, and overall well-being.
                </p>
                <a href="#">Learn More<i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="explore__card">
                <span><i class="ri-run-line"></i></span>
                <h4>Fat Loss</h4>
                <p>
                    Through a combination of workouts and expert guidance, we'll
                    empower you to reach your goals.
                </p>
                <a href="#">Learn More<i class="ri-arrow-right-line"></i></a>
            </div>
            <div class="explore__card">
                <span><i class="ri-shopping-basket-fill"></i></span>
                <h4>Weight Gain</h4>
                <p>
                    Designed for individuals, our program offers an effective approach
                    to gaining weight sustainably.
                </p>
                <a href="#">Learn More<i class="ri-arrow-right-line"></i></a>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="section__container footer__container">
        <span class="bg__blur"></span>
        <span class="bg__blur footer__blur"></span>
        <div class="footer__col">
            <div class="footer__logo"><img src="logo.png" alt="Logo"></div>
            <p>
                Take the first step towards a healthier, stronger you with our
                unbeatable pricing plans. Let's sweat, achieve, and conquer together!
            </p>
            <div class="footer__socials">
                <a href="#"><i class="ri-facebook-fill"></i></a>
                <a href="#"><i class="ri-instagram-line"></i></a>
                <a href="#"><i class="ri-twitter-fill"></i></a>
            </div>
        </div>
        <div class="footer__col">
            <h4>Company</h4>
            <a href="#">Business</a>
            <a href="#">Franchise</a>
            <a href="#">Partnership</a>
            <a href="#">Network</a>
        </div>
        <div class="footer__col">
            <h4>About Us</h4>
            <a href="#">Blogs</a>
            <a href="#">Security</a>
            <a href="#">Careers</a>
        </div>
        <div class="footer__col">
            <h4>Contact</h4>
            <a href="#">Contact Us</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">BMI Calculator</a>
        </div>
    </footer>
</body>
</html>
