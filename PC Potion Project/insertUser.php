<?php>
    require_once "connect.php";
    
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = &_POST['password'];

    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($username) && !empty($password)) {
        
        if (!empty($phone)) {
            
            if (substr($phone, 0, 1) != "0" && strlen($phone) != 11) {
                echo "Phone Number is invalid.";
                exit();
            }
            
            
            
        }
        
    } else {
        echo "Fields missing.";
        exit();
    }
?>