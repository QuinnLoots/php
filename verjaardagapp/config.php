<?php
   /* Database connection settings */
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'verjaardag_app_users';
    $mysqli = new mysqli( $host, $user, $pass,$db ) or die($mysqli->error);

   if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } 
    echo "Connected successfully";
?>