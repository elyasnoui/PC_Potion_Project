<?php
// Start the session
session_start();

$_SESSION['fnameErr'] = $_SESSION['lnameErr'] = $_SESSION['phoneErr'] = $_SESSION['emailErr'] = $_SESSION['rUsernameErr'] = $_SESSION['rPasswordErr'] = $_SESSION['lUsernameErr'] = $_SESSION['lPasswordErr'] = $_SESSION['cUsernameErr'] = $_SESSION['cEmailErr'] = $_SESSION['topicErr'] = $_SESSION['messageErr'] = $_SESSION['dateErr'] = $_SESSION['timeErr'] = "";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="description" content= "Highly specialised custom water-cooled PCs. Build the PC of your dreams!">
        <meta name="keywords" content="Gaming, PC, Custom Loop, Water Cooling, Loop, Water">
        <meta name="author" content="Elyas Noui">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="logo.ico">
        <link rel="stylesheet" href="styleSheet.css?v=<?php echo time(); ?>">
        <title>PC Potion</title>
    </head>
    <body>
        <div class="container" id="top">
            <div class="header">
                <!-- Logo: https://www.freelogodesign.org/ -->
                <a href="index.php"><img class="logo" src="logo.png" alt="Logo"></a>
                <a href="index.php"><img class="business-name" src="title.png" alt="Business Name"></a>
            </div>
            <div class="nav" id="mobile">
                <br>
                <a class="in-nav" href="index.php">Home</a>
                <a class="in-nav" href="about.php" id="selected">About</a>
                <a class="in-nav" href="contact.php">Contact</a>
                <div class="booking"><a class="in-nav" href="booking.php">Booking</a></div>
                <div class="nav-list">
                    <button onclick="drop()">&#9776;</button>
                    <div class="in-list" id="dropdown">
                        <a href="index.php">Home</a>
                        <a href="about.php">About</a>
                        <a href="contact.php">Contact</a>
                        <div class="booking"><a href="booking.php">Booking</a></div>
                    </div>
                </div>
                <a href="login.php" class="nav-login">Login</a>
                <a href="account.php" class="nav-user"></a>
            </div>
        </div>
        
        <div class="article">
            <div class="carousel">
                <button onclick="carousel(1)" class="arrows" style="float: right;" id="right">&#62;</button>
                <button onclick="carousel(-1)" class="arrows" id="left">&#60;</button>
                <div class="carousel-images">
                    <!-- Img Source: https://wegeek.fr/ek-se-lance-dans-les-pc-pre-montes-et-watercooles/ -->
                    <img id="hero-img" src="carousel_1.jpg">
                </div>
                <div class="carousel-images" id="hidden">
                    <!-- Img Source: https://forums.comunidades.riotgames.com/t5/Off-topic/Tem-curso-que-ensina-a-montar-pc-gamer/td-p/120031 -->
                    <img id="hero-img" src="carousel_2.jpg">
                </div>
                <div class="carousel-images" id="hidden">
                    <!-- Img Source: https://www.ekwb.com/wp-content/uploads/2017/07/DarkoRezic-build-by-SSPCmodding-08.jpg -->
                    <img id="hero-img" src="carousel_3.jpg">
                </div>
                <div class="carousel-images" id="hidden">
                    <!-- Img Source: https://i.pinimg.com/originals/09/0f/77/090f7769c5cb9d8cca8c6dc7f85fe24f.jpg -->
                    <img id="hero-img" src="carousel_4.jpg">
                </div>
                <div class="carousel-images" id="hidden">
                    <!-- Img Source: https://www.hardwareluxx.de/index.php/news/hardware/wasserkuehlung/52420-corsair-stellt-wasserkuehlungs-komponenten-in-weiss-vor.html -->
                    <img id="hero-img" src="carousel_5.jpg">
                </div>
                <div class="carousel-images" id="hidden">
                    <!-- Img Source: https://imgur.com/t/nvidia/qPvrvhf -->
                    <img id="hero-img" src="carousel_6.jpg">
                </div>
                <div class="carousel-images" id="hidden">
                    <!-- Img Source: https://www.pexels.com/search/water%20cooled%20pc/ -->
                    <img id="hero-img" src="carousel_7.png">
                </div>
            </div>
        </div>
        
        <div class="container" id="bottom" style="height: 460px">
            <p style="text-align: right;">Our Best Work &#x21D4;</p>
            <h2 style="display: inline;">FAQ</h2>
            <h3>Where do we operate?</h3>
            <p>We currently only operate in London, UK. We let our customers know any areas we expand to via our newsletter.</p>
            <h3>Do I have to buy my own parts?</h3>
            <p>Yes. If you're considering using our service, <a href="contact.php" class="p-link">CONTACT US</a> to get professional advice on what parts you should consider, which naturally vary based on your needs.</p>
            <h3>How much do we charge?</h3>
            <p>Customers only get charged on the hours we spend physically building your PC. This means that consulatation is FREE.</p>
            <p>We charge £20 an hour. Average jobs vary from 4-7 hours.</p>
            <h3>Is there warranty?</h3>
            <p>Since the parts you buy are your from seperate retailers, we do not provide a warranty/refunds for any products in your PC. If the fault concers any of your PC components, please contact the relevant manufacturer of that product, i.e. Asus, Intel...</p>
            <p>We do, however, offer a 12 month repair warranty for PCs  we have built.</p>
            <h3>How should I maintain my PC?</h3>
            <p>You can find an in-depth guide on how to maintain your watercooled PC <a href="https://www.novatech.co.uk/watercooledpc-maintenance/" class="p-link" target="_blank">here</a>.</p> 
            <p>Alternatively, for £20 you can book an appointment for one of our technicians to maintain it for you. It takes roughly 1 hour to fully maintain a custom loop PC.</p>
            <h3>What time do technicians arrive?</h3>
            <p>Building a custom loop PC will typically take up most of the day, because of this our technicians arrive early. On the day of the build we will send you a 1-hour time frame in which the technician will arrive.</p>
            <br>
            <p>If you have any other questions, please get in contact with our team <a href="contact.php" class="p-link">here</a>.</p>
            <div class="footer">
                <p>Copyright © 2020 PC Potion</p>
                <p><strong>Follow us on Social Media!</strong></p>
                <!-- FB Icon: https://www.flaticon.com/free-icon/instagram_733558?term=instagram&page=1&position=2 -->
                <a href="https://www.facebook.com/" target="_blank"><img src="facebook.png" style="width:4vw; min-width: 10px; max-width: 35px; padding: 1%;"></a>
                <!-- Twitter Icon: https://www.flaticon.com/free-icon/twitter_2111688?term=twitter&page=1&position=25 -->
                <a href="https://twitter.com/" target="_blank"><img src="twitter.png" style="width:4vw; min-width: 10px; max-width: 35px; padding: 1%;"></a>
                <!-- Instagram Icon: https://www.flaticon.com/free-icon/facebook_733547?term=facebook&page=1&position=1 -->
                <a href="https://www.instagram.com/" target="_blank"><img src="instagram.png" style="width:4vw; min-width: 10px; max-width: 35px; padding: 1%;"></a>
                <p><u>DISCLAIMER</u>:
                    PC Potion is a fictitious brand created solely for the purpose of the
                    assessment of IN1010 module at City, University of London, UK. All products and
                    people associated with PC Potion are also fictitious. Any resemblance to real
                    brands, products, or people is purely coincidental. Information provided about the
                    product is also fictitious and should not be construed to be representative of actual
                    products on the market in a similar product category.
                </p>
                <p>Author: Elyas Noui 190053026</p>
                <br>
            </div>
        </div>
    </body>
    <script>
        var carouselArr = document.getElementsByClassName("carousel-images");
        var carouselFocus = 0;
        
        function carousel(i) {
            this.carouselFocus += i;
            
            if (this.carouselFocus < 0) {
                this.carouselFocus = this.carouselArr.length - 1;
                this.carouselArr[0].style.display = "none";
            } else if (this.carouselFocus > this.carouselArr.length - 1) {
                this.carouselFocus = 0;
                this.carouselArr[this.carouselArr.length - 1].style.display = "none";
            } else {
                if (i==1)
                    this.carouselArr[this.carouselFocus - 1].style.display = "none";
                else if (i==-1)
                    this.carouselArr[this.carouselFocus + 1].style.display = "none";
            }
            
            console.log(this.carouselFocus);
            
            this.carouselArr[carouselFocus].style.display = "block";
        }
        
        function drop() {
            var menu = document.getElementById('dropdown');
            

            if (menu.style.display == 'none') menu.style.display = 'block';
            else menu.style.display = 'none';
        }
        
        function signedIn(username) {
            document.getElementsByClassName("nav-login")[0].style.display = "none";
            document.getElementsByClassName("nav-user")[0].style.display = "inline";
            document.getElementsByClassName("nav-user")[0].innerHTML = username;
            document.getElementsByClassName("booking")[0].style.display = "inline";
            document.getElementsByClassName("booking")[1].style.display = "inline";
        }
    </script>
    <?php
        
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        echo "<script> signedIn('$username'); </script>";
    }
    
    ?>
</html>