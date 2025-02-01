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


$car_details = $car->getCarById($car_id);


if (!$car_details) {
    die("Car not found.");
}


if ($car_details['username'] !== $_SESSION['username']) {
    die("You are not authorized to edit this car.");
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $car_name = $_POST['car_name'];
    $car_year = $_POST['car_year'];
    $car_image = $_FILES['car_image'];


    if ($car_image['error'] === UPLOAD_ERR_OK) {
        $file_name = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $car_image['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file_name);


        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }


        if (!move_uploaded_file($car_image['tmp_name'], $target_file)) {
            die("Error uploading the file.");
        }
    } else {

        $file_name = $car_details['car_image'];
    }


    if ($car->update($car_id, $car_name, $car_year, $file_name)) {
        header('Location: profili.php?message=Car updated successfully');
    } else {
        header('Location: profile.php?message=Failed to update car');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
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
    <h2>Edit Car</h2>
    <form action="edit_car.php?id=<?php echo $car_id; ?>" method="POST" enctype="multipart/form-data">
        <label for="carName">Car Name:</label>
        <input type="text" id="carName" name="car_name" value="<?php echo htmlspecialchars($car_details['car_name']); ?>" required>

        <label for="carYear">Year:</label>
        <input type="number" id="carYear" name="car_year" value="<?php echo htmlspecialchars($car_details['car_year']); ?>" min="1900" max="2023" required>

        <label for="carImage">Car Image:</label>
        <input type="file" id="carImage" name="car_image" accept="image/jpeg">

        <input type="submit" value="Update Car">
    </form>
</div>

</body>
</html>
