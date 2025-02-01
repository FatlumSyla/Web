<?php
require_once('DbConnect.php'); // Include the DB connection

class Car {
    private $dbConn;
    private $table = 'cars'; // Table name

    public function __construct() {
        $db = new DbConnect();
        $this->dbConn = $db->connect();
    }


    public function create($car_name, $car_year, $car_image, $username,$phoneNumber) {
        $sql = "INSERT INTO $this->table (car_name, car_year, car_image, username,phoneNumber) VALUES (:car_name, :car_year, :car_image, :username,:phoneNumber)";
        $stmt = $this->dbConn->prepare($sql);

   
        $stmt->bindParam(':car_name', $car_name);
        $stmt->bindParam(':car_year', $car_year);
        $stmt->bindParam(':car_image', $car_image);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':phoneNumber', $phoneNumber);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function getCarsByUser($username) {
        $sql = "SELECT * FROM $this->table WHERE username = :username";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function update($car_id, $car_name, $car_year, $car_image) {
        $sql = "UPDATE $this->table SET car_name = :car_name, car_year = :car_year, car_image = :car_image WHERE id = :car_id";
        $stmt = $this->dbConn->prepare($sql);


        $stmt->bindParam(':car_name', $car_name);
        $stmt->bindParam(':car_year', $car_year);
        $stmt->bindParam(':car_image', $car_image);
        $stmt->bindParam(':car_id', $car_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function delete($car_id) {
        $sql = "DELETE FROM $this->table WHERE id = :car_id";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':car_id', $car_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


public function getCarById($car_id) {
    $sql = "SELECT * FROM $this->table WHERE id = :car_id";
    $stmt = $this->dbConn->prepare($sql);
    $stmt->bindParam(':car_id', $car_id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
?>
