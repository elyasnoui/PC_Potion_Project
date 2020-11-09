<?php
// Start the session
session_start();

$_SESSION['lUsernameErr'] = $_SESSION['lPasswordErr'] = $_SESSION['cUsernameErr'] = $_SESSION['cEmailErr'] = $_SESSION['topicErr'] = $_SESSION['messageErr'] = "";
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
        <style>
            body {
                min-width: 540px;
            }
            
            @media only screen and (max-width: 520px) {
                h2 {
                    font-size: 49px;
                }
    
                .footer p {
                    font-size: 8.75px;
                }
    
                .footer ul {
                    display: inline;
                    margin: 0;
                }
                
                .footer img {
                    width: 10px;
                }
            }
        </style>
    </head>
    <body>
        <?php
        require_once "connection.php";
        
        if (isset($_SESSION['username'])) header('Location: index.php');
        if (!isset($_SESSION['rUsernameErr'])) header('Location: index.php');
        
        $fnameErr = $_SESSION['fnameErr'];
        $lnameErr = $_SESSION['lnameErr'];
        $phoneErr = $_SESSION['phoneErr'];
        $emailErr = $_SESSION['emailErr'];
        $usernameErr = $_SESSION['rUsernameErr'];
        $passwordErr = $_SESSION['rPasswordErr'];
        $fname = $lname = $phone = $email = $username = $password = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['fnameErr'] = $_SESSION['lnameErr'] = $_SESSION['phoneErr'] = $_SESSION['emailErr'] = $_SESSION['rUsernameErr'] = $_SESSION['rPasswordErr'] = "";
            $errors = 0;
            
            $fname = test_input($_POST['fname']);
            if (empty($_POST["fname"]) || !preg_match("/^[A-Za-z\s]{2,35}$/",$fname)) {
                $_SESSION['fnameErr'] = "Only letters and white space allowed";
                $errors++;
            }
            
            $lname = test_input($_POST['lname']);
            if (empty($_POST["lname"]) || !preg_match("/^[A-Za-z\s]{2,35}$/",$lname)) {
                $_SESSION['lnameErr'] = "Only letters and white space allowed";
                $errors++;
            }
            
            $phone = test_input($_POST['phone']);
            if (!empty($_POST['phone'])) {
                if (!preg_match("/^0[0-9]{10}$/",$phone)) {
                    $_SESSION['phoneErr'] = "Not a valid UK number";
                    $errors++;
                }
            } else $phone = "NULL";
            
            $email = test_input($_POST['email']);
            if (empty($_POST["email"]) || !preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$email)) {
                $_SESSION['emailErr'] = "Must be in email format";
                $errors++;
            }
            
            $username = test_input($_POST['username']);
            if (empty($_POST["username"]) || !preg_match("/^[a-zA-Z0-9-_]{5,20}$/",$username)) {
                $_SESSION['rUsernameErr'] = "Must be only numbers and letters with no spaces";
                $errors++;
            }
            
            if ($_POST["c-password"] != $_POST["password"]) {
                $_SESSION['rPasswordErr'] = "Passwords do not match";
                $errors++;
            }
            
            $password = test_input($_POST['password']);
            if (empty($_POST["password"]) || !preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':\\|,.<>\/?]).{8,20}$/",$password)) {
                $_SESSION['rPasswordErr'] = "Not strong enough";
                $errors++;
            } else $password = md5($password);
            
            $query = "SELECT email FROM Users WHERE email = '$email'";
            $result = $db->query($query);
            if ($result->num_rows > 0) {
                $_SESSION['emailErr'] = "Email already registered.";
                $errors++;
            }
            
            $query = "SELECT username FROM Users WHERE username = '$username'";
            $result = $db->query($query);
            if ($result->num_rows > 0) {
                $_SESSION['rUsernameErr'] = "Username already registered.";
                $errors++;
            }
            
            if ($errors > 0) {
                header('Location: '.$_SERVER['REQUEST_URI']);
                exit();
            }
            
            $insert = "INSERT INTO Users VALUES ('$username', '$fname', '$lname', $phone, '$email', '$password')";
            $result = $db->query($insert);
            $_SESSION['username'] = $username;
            header('Location: index.php');
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
            <div class="nav">
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
                <a href="login.php" class="nav-login" id="selected">Login</a>
            </div>
            <div class="div-form">
                <h2>Register</h2>
                <div class="errors">
                    <p class="alert-name">*First and last names must be only letters and</p>
                    <p class="alert-name">contain 2-35 characters.</p>
                    <br>
                    <p class="alert" id="phone-guide">*Please enter a valid 11 digit UK phone number.</p>
                    <br>
                    <p class="alert" id="email-guide">*Please enter a valid email.</p>
                    <br>
                    <p class="alert" id="username-guide">*Usernames must be 5-15 characters long.</p>
                    <br>
                    <p class="alert-password">*Passwords must be 8-20 characters long,</p>
                    <p class="alert-password">contain at least one uppercase letter,</p>
                    <p class="alert-password">contain at least one special character and</p>
                    <p class="alert-password">contain at least one number.</p>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" onsubmit="return valReg()">    
                    <span class="error" id="php"><?php echo $fnameErr;?></span><br>First Name:<br><input class="validate" type="text" name="fname" maxlength="35" value=""><span class="error">*</span><p class="alert" id="fname"><i>Invalid Entry</i></p>
                    <br>
                    <br>
                    <span class="error" id="php"><?php echo $lnameErr;?></span><br>Last Name:<br><input class="validate" type="text" name="lname" maxlength="35" value=""><span class="error">*</span><p class="alert" id="lname"><i>Invalid Entry</i></p>
                    <br>
                    <br>
                    <span class="error" id="php"><?php echo $phoneErr;?></span><br>Phone (Opt.):<br><input class="validate" type="text" name="phone" maxlength="11" value=""><p class="alert" id="phone"><i>Invalid Entry</i></p>
                    <br>
                    <br>
                    <span class="error" id="php"><?php echo $emailErr;?></span><br>Email:<br><input class="validate" type="text" name="email" maxlength="50" value=""><span class="error">*</span><p class="alert" id="email"><i>Invalid Entry</i></p>
                    <br>
                    <br>
                    <span class="error" id="php"><?php echo $usernameErr;?></span><br>Username:<br><input class="validate" type="text" name="username" maxlength="15" value=""><span class="error">*</span><p class="alert" id="username"><i>Invalid Entry</i></p>
                    <br>
                    <br>
                    <span class="error" id="php"><?php echo $passwordErr;?></span><br>Password:<br><input class="validate" type="password" name="password" maxlength="20" value=""><span class="error">*</span><p class="alert" id="password"><i>Invalid Entry</i></p>
                    <br>
                    <br>
                    <br>
                    Confirm Password:<br><input class="validate" type="password" name="c-password" maxlength="20" value=""><span class="error">* </span><p class="alert" id="c-password"><i>Does not match</i></p>
                    <br>
                    <br>
                    <input class="button" type="submit" value="Sign Up">
                    <p>Already have an account?</p>
                    <a href="login.php" class="p-link">LOGIN HERE</a>
                </form>
            </div>
            <div class="footer">
                <p>Copyright © 2020 PC Potion</p>
                <p><strong>Follow us on Social Media!</strong></p>
                <!-- FB Icon: https://www.flaticon.com/free-icon/instagram_733558?term=instagram&page=1&position=2 -->
                <a href="https://www.facebook.com/" target="_blank"><img src="facebook.png" style="width:4vw; min-width: 20px; max-width: 35px; padding: 1%;"></a>
                <!-- Twitter Icon: https://www.flaticon.com/free-icon/twitter_2111688?term=twitter&page=1&position=25 -->
                <a href="https://twitter.com/" target="_blank"><img src="twitter.png" style="width:4vw; min-width: 20px; max-width: 35px; padding: 1%;"></a>
                <!-- Instagram Icon: https://www.flaticon.com/free-icon/facebook_733547?term=facebook&page=1&position=1 -->
                <a href="https://www.instagram.com/" target="_blank"><img src="instagram.png" style="width:4vw; min-width: 20px; max-width: 35px; padding: 1%;"></a>
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
        var arr = document.getElementsByClassName("validate");
        var errorList = document.querySelectorAll(".errors p");
        //Password Regex: https://stackoverflow.com/questions/17102946/regex-for-password-validation-in-javascript
        var pwrd = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,20}$/;
        //Email Regex: https://stackoverflow.com/questions/7635533/validate-email-address-textbox-using-javascript/7635734
        var email = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        
        function drop() {
            var menu = document.getElementById('dropdown');
            
            if (menu.style.display == 'none') menu.style.display = 'block';
            else menu.style.display = 'none';
        }
        
        function valReg() {
            var val = true;
            
            //Remove all previous alerts from screen
            for (i=0; i<this.errorList.length; i++)
                this.errorList[i].style.display = 'none';
            
            //Loop through all input fields for validation
            for (i=0; i<this.arr.length; i++) {
                
                //Alert if either first or second name is not only characters and not between 2-35 char long
                if ((this.arr[i].name == "fname" || this.arr[i].name == "lname") && !/^[A-Za-z\s]{2,35}$/.test(this.arr[i].value)) {
                    document.getElementsByClassName("alert-name")[0].style.display = "block";
                    document.getElementsByClassName("alert-name")[1].style.display = "block";
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    val = false;
                }
                
                //Alert if not in mobile format
                if (this.arr[i].name == "phone" && (!this.arr[i].value.match(/^0[0-9]{10}$/)) && this.arr[i].value != "") {
                    document.getElementById("phone-guide").style.display = "block";
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    val = false;
                }
                
                //Alert if not in email format
                if (this.arr[i].name == "email" && (!email.test(this.arr[i].value) || this.arr[i].value.length > 50)) {
                    document.getElementById("email-guide").style.display = "block";
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    val = false;
                }
                
                //Alert if username is not between 5-20 char long
                if (this.arr[i].name == "username" && !/^[a-zA-Z0-9-_]{5,20}$/.test(this.arr[i].value)) {
                    document.getElementById("username-guide").style.display = "block";
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    val = false;
                }
                
                //Alert if password does not meet criteria
                if (this.arr[i].name == "password" && (!this.arr[i].value.match(pwrd))) {
                    document.getElementsByClassName("alert-password")[0].style.display = "block";
                    document.getElementsByClassName("alert-password")[1].style.display = "block";
                    document.getElementsByClassName("alert-password")[2].style.display = "block";
                    document.getElementsByClassName("alert-password")[3].style.display = "block";
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    val = false;
                }
                
                //Make sure passwords match
                if (this.arr[i].name == "c-password" && (this.arr[i].value != this.arr[i-1].value)) {
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    val = false;
                }
            }
            
            return val;
        }
    </script>
</html>