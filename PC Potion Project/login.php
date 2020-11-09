<?php
// Start the session
session_start();

$_SESSION['fnameErr'] = $_SESSION['lnameErr'] = $_SESSION['phoneErr'] = $_SESSION['emailErr'] = $_SESSION['rUsernameErr'] = $_SESSION['rPasswordErr'] = $_SESSION['cUsernameErr'] = $_SESSION['cEmailErr'] = $_SESSION['topicErr'] = $_SESSION['messageErr'] = "";
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
        if (!isset($_SESSION['lUsernameErr'])) header('Location: index.php');
        
        $usernameErr = $_SESSION['lUsernameErr'];
        $passwordErr = $_SESSION['lPasswordErr'];
        $username = $password = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['lUsernameErr'] = $_SESSION['lPasswordErr'] = "";
            $errors = 0;
            
            $username = test_input($_POST['username']);
            if (empty($_POST["username"]) || !preg_match("/^[a-zA-Z0-9-_]{5,20}$/",$username)) {
                $_SESSION['lUsernameErr'] = "Must be only numbers and letters with no spaces";
                $errors++;
            }
            
            $password = test_input($_POST['password']);
            if (empty($_POST["password"]) || !preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':\\|,.<>\/?]).{8,20}$/",$password)) {
                $_SESSION['lPasswordErr'] = "Not strong enough";
                $errors++;
            } else $password = md5($_POST['password']);
            
            if ($errors > 0) {
                header('Location: '.$_SERVER['REQUEST_URI']);
                exit();
            }
            
            $query = "SELECT username FROM Users WHERE username = '$username' AND password = '$password'";
            $result = $db->query($query);
            if ($result->num_rows == 1) {
                $_SESSION['username'] = $username;
                
                $insert = "INSERT INTO Logins VALUES ('$username', CURRENT_TIMESTAMP)";
                $result = $db->query($insert);
                
                header('Location: index.php');
            } else {
                $query = "SELECT username FROM Users WHERE username = '$username'";
                $result = $db->query($query);
                if ($result->num_rows == 1) $_SESSION['lPasswordErr'] = "Incorrect password";
                else $_SESSION['lUsernameErr'] = $username." does not exist";
            }
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
                <h2>Login</h2>
                <div class="errors">
                    <p class="alert" id="username-guide">*Usernames must be 5-15 characters long.</p>
                    <br>
                    <p class="alert-password" id="1">*Passwords must be 8-20 characters long,</p>
                    <p class="alert-password">contain at least one uppercase letter,</p>
                    <p class="alert-password">contain at least one special character and</p>
                    <p class="alert-password">contain at least one number.</p>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" onsubmit="return valLogin()">
                    <span class="error" id="php"><?php echo $usernameErr;?></span><br>Username:<br><input class="validate" type="text" name="username" maxlength="15" value=""><span class="error">*</span><p class="alert" id="username"><i>Invalid Entry</i></p>
                    <br>
                    <br>
                    <span class="error" id="php"><?php echo $passwordErr;?></span><br>Password:<br><input class="validate" type="password" name="password" maxlength="20" value=""><span class="error">*</span><p class="alert" id="password"><i>Invalid Entry</i></p>
                    <br>
                    <br>
                    <input class="button" type="submit" value="Login">
                    <p>Don't have an account?</p>
                    <a href="register.php" class="p-link">REGISTER HERE</a>
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
        
        function drop() {
            var menu = document.getElementById('dropdown');
            
            if (menu.style.display == 'none') menu.style.display = 'block';
            else menu.style.display = 'none';
        }
        
        function valLogin() {
            this.val = true;
            
            for (i=0; i<this.errorList.length; i++)
                this.errorList[i].style.display = 'none';
            
            for (i=0; i<this.arr.length; i++) {          
                if (this.arr[i].name == "username" && !/^[a-zA-Z0-9-]{5,20}$/.test(this.arr[i].value)) {
                    document.getElementById("username-guide").style.display = "block";
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    this.val = false;
                }
                
                if (this.arr[i].name == "password" && (!this.arr[i].value.match(pwrd))) {
                    document.getElementsByClassName("alert-password")[0].style.display = "block";
                    document.getElementsByClassName("alert-password")[1].style.display = "block";
                    document.getElementsByClassName("alert-password")[2].style.display = "block";
                    document.getElementsByClassName("alert-password")[3].style.display = "block";
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    this.val = false;
                }
            }
            
            return this.val;
        }
    </script>
</html>