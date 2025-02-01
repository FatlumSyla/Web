<?php

$HOSTNAME = 'localhost:3307'; 
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'ocardatabase'; 

$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if ($con) {
    echo "Connection successful";
} else {
    die("Connection failed: " . mysqli_connect_error()); 
}

?>
