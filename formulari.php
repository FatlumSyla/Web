<?php

session_start();


if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}


require_once 'DbConnect.php';
require_once 'Car.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $car = new Car();


    $car_name = $_POST['car_name'];
    $car_year = $_POST['car_year'];
    $car_image = $_FILES['car_image']; 
    $username = $_SESSION['username'];
    $phoneNumber = $_POST['phoneNumber']; 


    $file_name = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $car_image['name']);

   
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file_name);


    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }


    if (move_uploaded_file($car_image['tmp_name'], $target_file)) {
    
        if ($car->create($car_name, $car_year, $file_name, $username,$phoneNumber)) {
            echo "<span style='color: blue;'>Data inserted successfully!</span>";
        } else {
            echo "<span style='color: red;'>Error inserting data into the database.</span>";
        }
    } else {
        echo "<span style='color: red;'>Error uploading the file. Please try again.</span>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Car</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }

       
    </style>
</head>
<body>

<div class="form-container">
    <h2>Post a Car</h2>
    <form action="formulari.php" method="POST" enctype="multipart/form-data">
        <label for="carName">Car Name:</label>
        <input type="text" id="carName" name="car_name" required>

        <label for="carYear">Year:</label>
        <input type="number" id="carYear" name="car_year" min="1900" max="2023" required>

        <label for="carImage">Car Image:</label>
        <input type="file" id="carImage" name="car_image" accept="image/jpeg" required>

        <label for="phoneNumber">Phone Number:</label>
        <input type="number" id="phoneNumber" name="phoneNumber"  required>


        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>
