<?php
session_start();


if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}


require_once 'Car.php';


if (!isset($_GET['id'])) {
    die("Car ID is missing.");
}


$car_id = $_GET['id'];


$car = new Car();

if ($car->delete($car_id)) {
 
    header('Location: profili.php?message=Car deleted successfully');
} else {

    header('Location: profili.php?message=Failed to delete car');
}
?>
