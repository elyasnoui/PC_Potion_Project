<?php
    $db = new mysqli(...);
    
    if ($db->connect_error) {
        printf("Connection failed: %s/n" . $db->connect_error);
        exit();
    }
?>
