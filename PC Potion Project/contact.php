<?php
// Start the session
session_start();

$_SESSION['fnameErr'] = $_SESSION['lnameErr'] = $_SESSION['phoneErr'] = $_SESSION['emailErr'] = $_SESSION['rUsernameErr'] = $_SESSION['rPasswordErr'] = $_SESSION['lUsernameErr'] = $_SESSION['lPasswordErr'] = $_SESSION['dateErr'] = $_SESSION['timeErr'] = "";
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
        
        $usernameErr = $_SESSION['cUsernameErr'];
        $emailErr = $_SESSION['cEmailErr'];
        $topicErr = $_SESSION['topicErr'];
        $messageErr = $_SESSION['messageErr'];
        $username = $email = $topic = $message = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['cUsernameErr'] = $_SESSION['cEmailErr'] = $_SESSION['topicErr'] = $_SESSION['messageErr'] = "";
            $errors = 0;
            
            $username = test_input($_POST['username']);
            if (empty($_POST["username"]) || !preg_match("/^[a-zA-Z0-9-_]{5,20}$/",$username)) {
                $_SESSION['cUsernameErr'] = "Must be only numbers and letters with no spaces";
                $errors++;
            }
            
            $email = test_input($_POST['email']);
            if (empty($_POST["email"]) || !preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$email)) {
                $_SESSION['cEmailErr'] = "Must be in email format";
                $errors++;
            }
            
            $topic = test_input($_POST['topic']);
            if (empty($_POST["topic"]) || !preg_match("/[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/g",$topic) && !(strlen($topic) >= 5 && strlen($topic) <= 20)) {
                $_SESSION['topicErr'] = "Must be only numbers and letters with no spaces (5-20)";
                $errors++;
            }
            
            $message = test_input($_POST['message']);
            if (empty($_POST["message"]) || !preg_match("/[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/g",$message) && !(strlen($message) >= 20 && strlen($message) <= 500)) {
                $_SESSION['messageErr'] = "Must be only numbers and letters with no spaces (20-500)";
                $errors++;
            }
            
            if ($errors > 0) {
                header('Location: '.$_SERVER['REQUEST_URI']);
                exit();
            }
            
            $query = "SELECT username FROM Users WHERE username = '$username'";
            $result = $db->query($query);
            if ($result->num_rows == 0) {
                $_SESSION['cUsernameErr'] = $username." does not exist";
                $errors++;
            } else {
                if (isset($_SESSION['username'])) {
                    if ($username != $_SESSION['username']) {
                        $_SESSION['cUsernameErr'] = $username." does not match your username";
                        $errors++;
                    }
                } else {
                    $_SESSION['cUsernameErr'] = "You are not logged in";
                    $errors++;
                }
            }
            
            if ($errors > 0) {
                header('Location: '.$_SERVER['REQUEST_URI']);
                exit();
            }
            
            $sendTo = "elyas.noui@city.ac.uk";
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = 'To: PC Potion <'.$sendTo.'>';
            $headers[] = 'From: '.$username.' <'.$email.'>';
            
            //Help using: https://www.php.net/manual/en/function.mail.php
            if (mail($sendTo, $topic, $message, implode("\r\n", $headers)))
                echo "<script>alert('Email sent!');</script>";
            else
                echo "<script>alert('Not sent.');</script>";
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
                <a class="in-nav" href="contact.php" id="selected">Contact</a>
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
        
        <div class="article" id="contact">
            <img id="hero-img" src="contact_img.png">
            <h1 id="img-text">CONTACT</h1>
        </div>
        
        <div class="container"><p id="contact">Fill out the contact form to get in touch with us. By submitting a form, you will automatically book an appointment for one of our team members to get in touch to discuss further. We aim to respond to general enquires in 1-2 business days.</p></div>
        
        <div class="container" id="contact-form">
            <div class="c-info">
                <h3>Info</h3>
                <p2>Address: Northampton Square, Clerkenwell, London, EC1V 0HB</p2>
                <br>
                <br>
                <p2>Email: elyas.noui@city.ac.uk</p2>
                <br>
                <br>
                <p2>Phone: 020 7040 5060</p2>
                <br>
                <br>
                <p2>Opening Hours:</p2>
                <br>
                <p2>Mon-Sat: 9am-6pm</p2>
            </div>
            
            <div class="c-form">
                <div class="div-form">
                    <h3>Contact</h3>
                    <div class="errors">
                        <p class="alert" id="username-guide">*Usernames must be 5-15 characters long.</p>
                        <br>
                        <p class="alert" id="email-guide">*Please enter a valid email.</p>
                        <br>
                        <p class="alert-topic">*Topics must be 5-20 characters long</p>
                        <p class="alert-topic">with no special characters.</p>
                        <br>
                        <p class="alert-message">*Messages must be 20-500 characters long</p>
                        <p class="alert-message">with no special characters.</p>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" onsubmit="return valCon()">    
                        <span class="error" id="php"><?php echo $usernameErr;?></span><br>Username:<br><input class="validate" type="text" name="username" maxlength="15" value=""><span class="error">*</span><p class="alert" id="username"><i>Invalid Entry</i></p>
                        <br>
                        <br>
                        <span class="error" id="php"><?php echo $emailErr;?></span><br>Email:<br><input class="validate" type="text" name="email" maxlength="50" value=""><span class="error">*</span><p class="alert" id="email"><i>Invalid Entry</i></p>
                        <br>
                        <br>
                        <span class="error" id="php"><?php echo $topicErr;?></span><br>Topic:<br><input class="validate" type="text" name="topic" maxlength="20" value=""><span class="error">*</span><p class="alert" id="topic"><i>Invalid Entry</i></p>
                        <br>
                        <br>
                        <span class="error" id="php"><?php echo $messageErr;?></span><br>Message:<br><textarea class="validate" type="text" name="message" maxlength="500"></textarea><span class="error">*</span><p class="alert" id="message"><i>Invalid<br>Entry</i></p>
                        <br>
                        <br>
                        <input class="button" type="submit" value="Submit">
                        <p>Haven't signed in?</p>
                        <p><a href="login.php" class="p-link">LOGIN</a>/<a href="register.php" class="p-link">REGISTER</a>
                    </form>
                </div>
            </div>
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
        var arr = document.getElementsByClassName("validate");
        var errorList = document.querySelectorAll(".errors p");
        //Email Regex: https://stackoverflow.com/questions/7635533/validate-email-address-textbox-using-javascript/7635734
        var email = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        
        function drop() {
            var menu = document.getElementById('dropdown');
            
            if (menu.style.display == 'none') menu.style.display = 'block';
            else menu.style.display = 'none';
        }
        
        function valCon() {
            this.val = true;
            
            for (i=0; i<this.errorList.length; i++)
                this.errorList[i].style.display = 'none';
            
            for (i=0; i<this.arr.length; i++) {          
                if (this.arr[i].name == "username" && !/^[a-zA-Z0-9-]{5,20}$/.test(this.arr[i].value)) {
                    document.getElementById("username-guide").style.display = "block";
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    this.val = false;
                }
                
                //Alert if not in email format
                if (this.arr[i].name == "email" && (!email.test(this.arr[i].value) || this.arr[i].value.length > 50)) {
                    document.getElementById("email-guide").style.display = "block";
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    this.val = false;
                }
                
                if (this.arr[i].name == "topic" && !/[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/g.test(this.arr[i].value) && !(this.arr[i].value.length >= 5 && this.arr[i].value.length <= 20)) {
                    document.getElementsByClassName("alert-topic")[0].style.display = "block";
                    document.getElementsByClassName("alert-topic")[1].style.display = "block";
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    this.val = false;
                }
                
                if (this.arr[i].name == "message" && !this.arr[i].value.match(/[^\r\n]+((\r|\n|\r\n)[^\r\n]+)*/g) && !(this.arr[i].value.length >= 5 && this.arr[i].value.length <= 500)){
                    document.getElementsByClassName("alert-message")[0].style.display = "block";
                    document.getElementsByClassName("alert-message")[1].style.display = "block";
                    document.getElementById(this.arr[i].name).style.display = "inline";
                    this.val = false;
                }
            }
            return this.val;
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