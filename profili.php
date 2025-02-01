<?php
session_start();


if (!isset($_SESSION['username'])) {
 
    header('Location: login.php');
    exit();
}


$username = $_SESSION['username'];


require_once 'DbConnect.php';


$dbConnect = new DbConnect();
$conn = $dbConnect->connect();


if (!$conn) {
    die("Database connection failed.");
}


$sql = "SELECT * FROM cars WHERE username = :username"; // Corrected query

try {
   
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username); 
    $stmt->execute();

    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        header {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background-color: black;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .logo {
            padding-left: 40px;
            font-size: 3em;
            color: yellow;
            text-decoration: none;
            user-select: none;
            margin-right: auto;
        }
        .navigation {
            display: flex;
            align-items: center;
            gap: 60px;
            margin-left: auto;
        }
        .navigation a {
            font-size: 1.1em;
            color: white;
            text-decoration: none;
            font-weight: 500;
        }
        .button-container {
            display: flex;
            gap: 15px;
        }
        .login-button, .signup-button {
            padding: 8px 16px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: yellow;
            color: rgb(0, 0, 0);
            transition: background-color 0.2s ease;
            position: relative;
            right:50px;
        }

        .login-button{
            background-color: blue;
        }
        .login-button:hover{
            background-color: darkblue;
        }
        .signup-button:hover {
            background-color: #86a814;
        }
        #h {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 100px;
        }
        .car-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px auto;
            max-width: 1200px;
            padding: 20px;
        }
        .car-box {
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .car-box img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ccc;
        }
        .car-box h3 {
            font-size: 1.2rem;
            margin: 10px 0;
        }
        .car-box p {
            color: #666;
            margin-bottom: 10px;
        }
        .car-box .actions {
            display: flex;
            justify-content: space-around;
            padding: 10px;
        }
        .car-box .actions button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.2s ease;
        }
        .car-box .actions .edit-button {
            background-color: #4CAF50;
            color: white;
        }
        .car-box .actions .delete-button {
            background-color: #f44336;
            color: white;
        }
        .car-box .actions .edit-button:hover {
            background-color: #45a049;
        }
        .car-box .actions .delete-button:hover {
            background-color: #e53935;
        }
        .no-data {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <header>
        <a href="index.html" class="logo">OnlineCar</a>
        <nav class="navigation">
            <button onclick="location.href='formulari.php'" class="signup-button">Sell a Car</button>
            <button onclick="location.href='logout.php'" class="login-button">Logout</button>
        </nav>
    </header>

    <h1 id="h">Welcome, <?php echo htmlspecialchars($username); ?>!</h1>

    <div class="car-container">
        <?php
        if (count($result) > 0) {
            foreach ($result as $row) {
                $car_id = htmlspecialchars($row['id']); 
                $car_name = htmlspecialchars($row['car_name']);
                $car_year = htmlspecialchars($row['car_year']);
                $car_image = htmlspecialchars($row['car_image']);

        
                $image_path = 'uploads/' . $car_image;
                if (!file_exists($image_path)) {
                    $image_path = 'uploads/default.jpg';
                }

                echo "
                    <div class='car-box'>
                        <img src='$image_path' alt='Car Image'>
                        <h3>$car_name</h3>
                        <p>Year: $car_year</p>
                        <div class='actions'>
                            <button class='edit-button' onclick=\"location.href='edit_car.php?id=$car_id'\">Edit</button>
                            <button class='delete-button' onclick=\"confirmDelete($car_id)\">Delete</button>
                        </div>
                    </div>
                ";
            }
        } else {
            echo "<p class='no-data'>No cars found for your account.</p>";
        }
        ?>
    </div>

    <script>
   
        function confirmDelete(carId) {
            if (confirm("Are you sure you want to delete this car?")) {
          
                window.location.href = `delete_car.php?id=${carId}`;
            }
        }
    </script>

</body>
</html>
