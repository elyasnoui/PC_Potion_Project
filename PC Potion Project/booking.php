<?php
// Start the session
session_start();

$_SESSION['cUsernameErr'] = $_SESSION['cEmailErr'] = $_SESSION['topicErr'] = $_SESSION['messageErr'] = "";
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
    <body id="contact">
        <?php
        require_once "connection.php";
        
        if (!isset($_SESSION['username'])) header('Location: index.php');
        
        $dateErr = $_SESSION['dateErr'];
        $timeErr = $_SESSION['timeErr'];
        $username = $_SESSION['username'];
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['dateErr'] = $_SESSION['timeErr'] = "";
            $errors = 0;
            
            $date = $_POST['date'];
            if (count($date) != 1) {
                $_SESSION['dateErr'] = "*Select only 1 date";
                $errors++;
            } else {
                $date = test_input($date[0]);
                if (!preg_match("/^\d{4}[\-\/]\d{2}[\-\/]\d{2}$/",$date)) {
                    $_SESSION['dateErr'] = "*Invalid date";
                    $errors++;
                }
            }
            
            $time = $_POST['time'];
            if (count($time) != 1) {
                $_SESSION['timeErr'] = "*Select only 1 time";
                $errors++;
            } else {
                $time = test_input($time[0]);
                //Date Regex: https://regexr.com/31dth
                if (!preg_match("/(0[9]|1[0-8]):0[0]/",$time)) {
                    $_SESSION['timeErr'] = "*Invalid time";
                    $errors++;
                }
            }
            
            $query = "SELECT date, time FROM Bookings WHERE date = '$date' AND time = '$time'";
            $result = $db->query($query);
            if ($result->num_rows > 0) {
                $_SESSION['dateErr'] = $date.", ".$time." has already been booked";
                $_SESSION['timeErr'] = "Please pick another time";
                $errors++;
            }
            
            $query = "SELECT date, time FROM Bookings WHERE username = '$username'";
            $result = $db->query($query);
            while ($row = $result->fetch_assoc()) {
                $dateCheck = $row["date"];
                $timeCheck = $row["time"];
                $dt = $dateCheck." ".$timeCheck;
                $now = date("Y-m-d H:i");
                if ($dt > $now) {
                    $_SESSION['dateErr'] = "You have already booked an appointment";
                    $_SESSION['timeErr'] = "Check your account for booking history";
                    $errors++;
                }
            }
            
            if ($errors > 0) {
                header('Location: '.$_SERVER['REQUEST_URI']);
                exit();
            }
            
            $insert = "INSERT INTO Bookings VALUES ('$username', '$date', '$time')";
            $result = $db->query($insert);
            header('Location: booking-history.php');
        }
            
        //IN1010 Session 6 page 66
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>
        <div class="container" id="top">
            <div class="header">
                <!-- Logo: https://www.freelogodesign.org/ -->
                <a href="index.php"><img class="logo" src="logo.png" alt="Logo"></a>
                <a href="index.php"><img class="business-name" src="title.png" alt="Business Name"></a>
            </div>
            <div class="nav">
                <br>
                <a class="in-nav" href="index.php">Home</a>
                <a class="in-nav" href="about.php">About</a>
                <a class="in-nav" href="contact.php">Contact</a>
                <div class="booking"><a class="in-nav" href="booking.php" id="selected">Booking</a></div>
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
        
        <div class="article" id="contact">
            <img id="hero-img" src="booking.png">
            <h1 id="img-text">BOOKINGS</h1>
        </div>
        
        <div class="container"><p id="contact">Book an appointment to speak to one of our agents. Select a date and time that suits you best. Appointments last 1 hour, i.e booking an appointment at 10:00 will last until 11:00. You can only book one appointment at a time. Check your account to see your booked appointments.</p><br><p style="text-align:center;">Please Note: Only select one date and one time.</p></div>
        <div class="container">
            <div class="div-form" id="booking">
                <h2>Appointments</h2>
                <div class="errors">
                    <span class="error" id="php"><?php echo $dateErr;?></span>
                    <p class="alert" id="date-guide"><i>*Please pick 1 Date</i></p>
                    <br>
                    <span class="error" id="php"><?php echo $timeErr;?></span>
                    <p class="alert" id="time-guide"><i>*Please pick 1 Time</i></p>
                    <p class="alert" id="time-guide2"><i>*Saturdays are only from 10am-5pm</i></p>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" onsubmit="return valApp()">
                    <table class="content">
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td>
                                <input type="checkbox" class="timebox" name="time[]" value="09:00" />
                                <label>09:00</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td>
                                <input type="checkbox" class="timebox" name="time[]" value="10:00" />
                                <label>10:00</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td>
                                <input type="checkbox" class="timebox" name="time[]" value="11:00" />
                                <label>11:00</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td>
                                <input type="checkbox" class="timebox" name="time[]" value="12:00" />
                                <label>12:00</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td>
                                <input type="checkbox" class="timebox" name="time[]" value="13:00" />
                                <label>13:00</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td>
                                <input type="checkbox" class="timebox" name="time[]" value="14:00" />
                                <label>14:00</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td>
                                <input type="checkbox" class="timebox" name="time[]" value="15:00" />
                                <label>15:00</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td>
                                <input type="checkbox" class="timebox" name="time[]" value="16:00" />
                                <label>16:00</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td>
                                <input type="checkbox" class="timebox" name="time[]" value="17:00" />
                                <label>17:00</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td>
                                <input type="checkbox" class="timebox" name="time[]" value="18:00" />
                                <label>18:00</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date" value=""></label>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="datebox" name="date[]" value="" />
                                <label class="date"></label>
                            </td>
                            <td></td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <input class="button" type="submit" value="Request an appointment">
                </form>
            </div>
            <br>
        </div>
        
        <div class="container" id="contact">
            <div class="footer">
                <p>Copyright © 2020 PC Potion</p>
                <p><strong>Follow us on Social Media!</strong></p>
                <!-- FB Icon: https://www.flaticon.com/free-icon/instagram_733558?term=instagram&page=1&position=2 -->
                <a href="https://www.facebook.com/" target="_blank"><img src="facebook.png" style="width:4vw; min-width: 25px; max-width: 35px; padding: 1%;"></a>
                <!-- Twitter Icon: https://www.flaticon.com/free-icon/twitter_2111688?term=twitter&page=1&position=25 -->
                <a href="https://twitter.com/" target="_blank"><img src="twitter.png" style="width:4vw; min-width: 25px; max-width: 35px; padding: 1%;"></a>
                <!-- Instagram Icon: https://www.flaticon.com/free-icon/facebook_733547?term=facebook&page=1&position=1 -->
                <a href="https://www.instagram.com/" target="_blank"><img src="instagram.png" style="width:4vw; min-width: 25px; max-width: 35px; padding: 1%;"></a>
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
        var arrDate = document.getElementsByClassName("date");
        var arrDateBox = document.getElementsByClassName("datebox");
        var arrTimeBox = document.getElementsByClassName("timebox");
        var errorList = document.querySelectorAll(".errors p");
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var date = new Date();

        //Help from: https://www.tutorialspoint.com/increment-a-date-in-javascript-without-using-any-libraries, https://stackoverflow.com/questions/24998624/day-name-from-date-in-js/24998705
        for (i=0; i<this.arrDate.length; i++) {
            var next = new Date();
            next.setDate(this.date.getDate() + (i));
            
            var dd = next.getDate();
            var mm = next.getMonth() + 1;
            if (dd<=9) dd = '0'+dd;
            if (mm<=9) mm = '0'+mm;
            
            this.arrDate[i].innerHTML = this.days[next.getDay()]+" - "+dd+"/"+mm+"/"+next.getFullYear();
            this.arrDateBox[i].value = next.getFullYear()+"-"+mm+"-"+dd;
            
            if (this.days[next.getDay()] == 'Sunday') {
                this.arrDate[i].style.display = 'none';
                this.arrDateBox[i].style.display = 'none';
            }
        }
        
        function valApp() {
            var dCount = 0;
            var tCount = 0;
            
            for (i=0; i<this.errorList.length; i++)
                this.errorList[i].style.display = 'none';
            
            for (i=0; i<this.arrDateBox.length; i++)
                if (this.arrDateBox[i].checked) dCount++;
            
            for (i=0; i<this.arrTimeBox.length; i++)
                if (this.arrTimeBox[i].checked) tCount++;
            
            if (dCount != 1) document.getElementById("date-guide").style.display = 'block';
            if (tCount != 1) document.getElementById("time-guide").style.display = 'block';
            
            if (dCount != 1 || tCount != 1) return false;
            
            return true;
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
    } else header('Location: index.php');
    
    ?>
</html>