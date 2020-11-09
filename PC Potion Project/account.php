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
        
        $usernamePh = $_SESSION['username'];
        $query = "SELECT email, phone FROM Users WHERE username = '$usernamePh'";
        $result = $db->query($query);
        while ($row = $result->fetch_assoc()) {
            $emailPh = $row['email'];
            $phonePh = $row['phone'];
        }
        
        $rUsernameErr = $_SESSION['lUsernameErr'];
        $rPasswordErr = $_SESSION['lPasswordErr'];
        $phoneErr = $_SESSION['phoneErr'];
        $emailErr = $_SESSION['emailErr'];
        $username = $phone = $email = $password = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['lUsernameErr'] = $_SESSION['lPasswordErr'] = $_SESSION['phoneErr'] = $_SESSION['emailErr'] = "";
            $errors = 0;
            
            $username = test_input($_POST['username']);
            if (!empty($_POST['username']))
                if (!preg_match("/^[a-zA-Z0-9-_]{5,20}$/",$username)) {
                    $_SESSION['lUsernameErr'] = "*Usernames must be only numbers and letters with no spaces";
                    $errors++;
                }
            
            $email = test_input($_POST['email']);
            if (!empty($_POST['email']))
                if (!preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$email)) {
                    $_SESSION['emailErr'] = "*Must be in email format";
                    $errors++;
                }
            
            $phone = test_input($_POST['phone']);
            if (!empty($_POST['phone']))
                if (!preg_match("/^0[0-9]{10}$/",$phone)) {
                    $_SESSION['phoneErr'] = "*Must be a valid UK number";
                    $errors++;
                }
            
            $password = test_input($_POST['password']);
            $password = md5($_POST['password']);
            $query = "SELECT username FROM Users WHERE username = '$usernamePh' AND password = '$password'";
            $result = $db->query($query);
            if ($result->num_rows != 1) {
                $_SESSION['lPasswordErr'] = "*Password does not match account";
                $errors++;
            }
            
            if (empty($_POST['username']) && empty($_POST['email']) && empty($_POST['phone']))
                $errors++;
            
            if ($errors > 0) {
                header('Location: '.$_SERVER['REQUEST_URI']);
                exit();
            }
            
            if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['phone']))
                $query = "UPDATE Users SET username = '$username', email = '$email', phone = '$phone' WHERE username = '$usernamePh'";
            elseif (!empty($_POST['username']) && !empty($_POST['email']) && empty($_POST['phone']))
                $query = "UPDATE Users SET username = '$username', email = '$email' WHERE username = '$usernamePh'";
            elseif (!empty($_POST['username']) && empty($_POST['email']) && !empty($_POST['phone']))
                $query = "UPDATE Users SET username = '$username', phone = '$phone' WHERE username = '$usernamePh'";
            elseif (!empty($_POST['username']) && empty($_POST['email']) && empty($_POST['phone']))
                $query = "UPDATE Users SET username = '$username' WHERE username = '$usernamePh'";
            elseif (empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['phone']))
                $query = "UPDATE Users SET email = '$email', phone = '$phone' WHERE username = '$usernamePh'";
            elseif (empty($_POST['username']) && !empty($_POST['email']) && empty($_POST['phone']))
                $query = "UPDATE Users SET email = '$email' WHERE username = '$usernamePh'";
            elseif (empty($_POST['username']) && empty($_POST['email']) && !empty($_POST['phone']))
                $query = "UPDATE Users SET phone = '$phone' WHERE username = '$usernamePh'";
            
            $result = $db->query($query);
            if ($result) {
                if (empty($_POST['username'])) $_SESSION['username'] = $usernamePh;
                else $_SESSION['username'] = $username;
                $_SESSION['lUsernameErr'] = "Details successfully updated";
            } else {
                if (!empty($_POST['email'])) $_SESSION['lUsernameErr'] = "Email is invalid";
                else $_SESSION['lUsernameErr'] = "Service not available";
            } 
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
                        <br>
                        <p class="acc-alert" id="username"><i>*Usernames must be only numbers and letters with dashes and underscores (5-20)</i></p>
                        <p class="acc-alert" id="email"><i>*Must be in email format</i></p>
                        <p class="acc-alert" id="phone"><i>*Must be a valid UK number</i></p>
                        <p class="acc-alert" id="password"><i>*Invalid password</i></p>
                        <span class="acc-error"><?php echo $rUsernameErr;?></span>
                        <span class="acc-error"><?php echo $emailErr;?></span>
                        <span class="acc-error"><?php echo $phoneErr;?></span>   <span class="acc-error"><?php echo $rPasswordErr;?></span>
                        <table>
                            <tr>
                                <th>Username</th>
                                <td>
                                    <input class="acc-validate" type="text" name="username" maxlength="15" placeholder="<?php echo $usernamePh;?>" value="">
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>
                                    <input class="acc-validate" type="text" name="email" maxlength="50" placeholder="<?php echo $emailPh;?>" value="">
                                </td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>
                                    <input class="acc-validate" type="text" name="phone" maxlength="11" placeholder="0<?php echo $phonePh;?>" value="">
                                </td>
                            </tr>
                            <tr>
                                <th><p></p></th>
                                <td><p></p></td>
                            </tr>
                            <tr>
                                <th><p></p></th>
                                <td><p></p></td>
                            </tr>
                            <tr>
                                <th><p></p></th>
                                <td><p></p></td>
                            </tr>
                            <tr>
                                <th>
                                    Password
                                </th>
                                <td>
                                    <input class="acc-validate" type="password" name="password" maxlength="20" value="" required>
                                </td>
                            </tr>
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
        var errorList = document.getElementsByClassName("acc-alert");
        var phpList = document.getElementsByClassName("acc-error");
        //Password Regex: https://stackoverflow.com/questions/17102946/regex-for-password-validation-in-javascript
        var pwrd = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,20}$/;
        //Email Regex: https://stackoverflow.com/questions/7635533/validate-email-address-textbox-using-javascript/7635734
        var email = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        
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
            
            for (i=0; i<this.errorList.length; i++)
                this.errorList[i].style.display = 'none';
            for (i=0; i<this.phpList.length; i++)
                this.phpList[i].style.display = 'none';
            
            for (i=0; i<this.arr.length; i++) {
                
                //Alert if username is not between 5-20 char long
                if (this.arr[i].name == "username" && this.arr[i].value !=0 && !/^[a-zA-Z0-9-_]{5,20}$/.test(this.arr[i].value)) {
                    document.getElementById(this.arr[i].name).style.display = "block";
                    val = false;
                }
                
                //Alert if not in email format
                if (this.arr[i].name == "email" && this.arr[i].value !=0 && (!email.test(this.arr[i].value) || this.arr[i].value.length > 50)) {
                    document.getElementById(this.arr[i].name).style.display = "block";
                    val = false;
                }
                
                //Alert if not in mobile format
                if (this.arr[i].name == "phone" && (!this.arr[i].value.match(/^0[0-9]{10}$/)) && this.arr[i].value != "") {
                    document.getElementById(this.arr[i].name).style.display = "block";
                    val = false;
                }
                
                //Alert if password does not meet criteria
                if (this.arr[i].name == "password" && (!this.arr[i].value.match(pwrd))) {
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