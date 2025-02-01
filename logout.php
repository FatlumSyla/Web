<?php
require_once 'User.php'; // Include the User class

$user = new User();

if ($user->logout()) {
    // Redirect to the login page or home page after logout
    header("Location: login.php"); // Change 'login.php' to your desired destination
    exit();
} else {
    echo "Logout failed.";
}
?>
