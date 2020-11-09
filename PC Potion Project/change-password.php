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
        
        if (!isset($_SESSION['username'])) header('Location: index.php');
        
        $username = $_SESSION['username'];
        $rPasswordErr = $_SESSION['rPasswordErr'];
        $password = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['rPasswordErr'] = "";
            $errors = 0;
            
            if ($_POST["c-password"] != $_POST["password"]) {
                $_SESSION['rPasswordErr'] = "*Passwords do not match";
                $errors++;
            }
            
            $password = test_input($_POST['old-password']);
            $password = md5($password);
            $query = "SELECT username FROM Users WHERE username = '$username' AND password = '$password'";
            $result = $db->query($query);
            if ($result->num_rows != 1) {
                $_SESSION['rPasswordErr'] = "*Password does not match account";
                $errors++;
            }
            
            $password = test_input($_POST['password']);
            if (empty($_POST["password"]) || !preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':\\|,.<>\/?]).{8,20}$/",$password)) {
                $_SESSION['rPasswordErr'] = "*Not strong enough";
                $errors++;
            } else $password = md5($password);
                
            if ($errors > 0) {
                header('Location: '.$_SERVER['REQUEST_URI']);
                exit();
            }
            
            $query = "UPDATE Users SET password = '$password' WHERE username = '$username'";
            $result = $db->query($query);
            if ($result) $_SESSION['rPasswordErr'] = "Password updated";
            else $_SESSION['rPasswordErr'] = "Service not available";
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
        
        //IN1010 Session 6 page 66
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
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
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" onsubmit="return valAcc()">
                        <div class="error">
                            <p class="acc-alert" id="password"><i>*Passwords must be 8-20 characters long, contain at least one uppercase letter, contain at least one special character and contain at least one number.</i></p>
                            <span class="acc-error"><?php echo $rPasswordErr;?></span>
                        </div>                
                        <table id="security">
                            <thead>
                                <tr>
                                    <th>Old Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input class="acc-validate" type="password" name="old-password" maxlength="20" value="">
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th>New Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input class="acc-validate" type="password" name="password" maxlength="20" value="">
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th>Confirm Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input class="acc-validate" type="password" name="c-password" maxlength="20" value=""><p class="alert" id="c-password"><i>*Does not match</i></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input class="button" type="submit" value="Edit">
                    </form>
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
        var arr = document.getElementsByClassName("acc-validate");
        var error = document.getElementsByClassName("acc-alert")[0];
        var php = document.getElementsByClassName("acc-error")[0];
        //Password Regex: https://stackoverflow.com/questions/17102946/regex-for-password-validation-in-javascript
        var pwrd = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,20}$/;
        
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
        
        function valAcc() {
            var val = true;
            
            this.error.style.display = 'none';
            this.php.style.display = 'none';
            document.getElementById("c-password").style.display = "none";
            
            for (i=0; i<this.arr.length; i++) {
                
                //Alert if password does not meet criteria
                if ((this.arr[i].name == "old-password" || this.arr[i].name == "password") && (!this.arr[i].value.match(pwrd))) {
                    this.error.style.display = "block";
                    val = false;
                }
                
                //Make sure passwords match
                if (this.arr[i].name == "c-password" && (this.arr[i].value != this.arr[i-1].value)) {
                    document.getElementById(this.arr[i].name).style.display = "block";
                    val = false;
                }
            } return val;
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