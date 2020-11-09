<?php
    $db = new mysqli('fareham.city.ac.uk', 'adbb937', '190053026', 'adbb937');
    
    if ($db->connect_error) {
        printf("Connection failed: %s/n" . $db->connect_error);
        exit();
    }
?>