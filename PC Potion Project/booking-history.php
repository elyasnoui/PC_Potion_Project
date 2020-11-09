<?php
// Start the session
session_start();

$_SESSION['cUsernameErr'] = $_SESSION['cEmailErr'] = $_SESSION['topicErr'] = $_SESSION['messageErr'] = $_SESSION['dateErr'] = $_SESSION['timeErr'] = ""; 
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
        <?php
        require_once "connection.php";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $username = $_SESSION['username'];
            $date = $_SESSION['date'];
            $time = $_SESSION['time'];
            $query = "DELETE FROM Bookings WHERE username = '$username' AND date = '$date' AND time = '$time'";
            $result = $db->query($query);
            
        }
        ?>
        <div class="container">
            <div class="header">
                <!-- Logo: https://www.freelogodesign.org/ -->
                <a href="index.php"><img class="logo" src="logo.png" alt="Logo"></a>
                <a href="index.php"><img class="business-name" src="title.png" alt="Business Name"></a>
            </div>
            <div class="nav" id="mobile">
                <br>
                <a class="in-nav" href="index.php">Home</a>
                <a class="in-nav" href="about.php">About</a>
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
                <a href="account.php" class="nav-login" id="selected"></a>
            </div>
            <h2 id="mobile">My Account</h2>
            <div class="div-form" id="account">
                <div class="sidenav">
                    <ul>
                        <li><a href="account.php">My Details</a></li>
                        <li><a href="change-password.php">Security</a></li>
                        <li><a href="booking-history.php">My Bookings</a></li>
                        <li><a href="login-history.php">Login History</a></li>
                        <li><a href="sign-out.php">Sign Out</a></li>
                    </ul>
                </div>
                <div class="acc-content">
                    <h3 style="text-align: center;">My Appointments</h3>
                    
                    <?php
                    
                    if (!isset($_SESSION['username'])) header('Location: index.php');
                    
                    $username = $_SESSION['username'];
                    $query = "SELECT date, time FROM Bookings WHERE username = '$username' ORDER BY date, time";
                    $result = $db->query($query);
                    echo "<table class='content'>".
                             "<thead>".
                             "<tr>".
                             "<th>Booking</th>".
                             "<th id='cancel'></th>".
                             "</tr>".
                             "</thead>".
                             "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        
                        //Help from: https://stackoverflow.com/questions/470617/how-do-i-get-the-current-date-and-time-in-php
                        $date = $row["date"];
                        $time = $row["time"];
                        $dt = $date." ".$time;
                        $now = date("Y-m-d H:i");
                        echo "<td>$dt</td>";
                        if ($dt > $now) {
                            $_SESSION['date'] = $date;
                            $_SESSION['time'] = $time;
                            //Img Source: https://www.flaticon.com/free-icon/close_463612?term=cancel&page=1&position=29
                            echo "<td id='cancel'><button onclick='cancel()'><img src='cancel.png' alt='Cancel'></button></td>";
                        }
                        else echo "<td></td>";
                        
                        echo "</tr>";
                    }
                    echo "</tbody>".
                         "</table>";
                            
                    ?>
                    
                    <div class="confirm">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                            <h3>Are you sure?</h3>
                            <input class="button" id="yes" type="submit" value="Yes">
                            <input class="button" id="no" type="button" value="No" onclick="cancel()" style="display:inline;">
                        </form>
                    </div>
                </div>
            </div>
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
        var form = document.getElementsByClassName("confirm")[0];
        var display = false;
        
        function drop() {
            var menu = document.getElementById('dropdown');

            if (menu.style.display == 'none') menu.style.display = 'block';
            else menu.style.display = 'none';
        }
        
        function signedIn(username) {
            document.getElementsByClassName("nav-login")[0].innerHTML = username;
            document.getElementsByClassName("booking")[0].style.display = "inline";
            document.getElementsByClassName("booking")[1].style.display = "inline";
        }
        
        function cancel() {
            if (!this.display)
                this.form.style.display = "block";
            else this.form.style.display = "none";
            this.display = !this.display;
        }
    </script>
    <?php
        
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        echo "<script> signedIn('$username'); </script>";
    }
    else header('Location: index.php');
    
    ?>
</html>