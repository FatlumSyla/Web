<?php
require_once('DbConnect.php');

class User {
    private $dbConn;
    private $registration = 'registration'; 
    private $registration2 = 'contact';

    public function __construct() {
        $db = new DbConnect();
        $this->dbConn = $db->connect();
    }
    public function create2($username, $password, $role = "user") {
        $sql = "INSERT INTO $this->registration (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->dbConn->prepare($sql);
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function create($username, $password, $role = "admin") {
        $sql = "INSERT INTO $this->registration (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->dbConn->prepare($sql);
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function sendMessage($name, $email, $message ) {
        $sql = "INSERT INTO $this->registration2 (name, email, message) VALUES (:name, :email, :message)";
        $stmt = $this->dbConn->prepare($sql);
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    


    public function login($username, $password) {
        $sql = "SELECT * FROM $this->registration WHERE username = :username";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
     
        if ($user && $password === $user['password']) {
            session_start();
            $_SESSION['username'] = $user['username']; 
            $_SESSION['role'] = $user['role'];

            return $user['role'];
            return true;
        } else {
            return false;
        }
    }

    public function update($currentUsername, $newUsername, $newPassword) {
      

        $sql = "UPDATE $this->registration SET username = :newUsername, password = :newPassword WHERE username = :currentUsername";
        $stmt = $this->dbConn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':newUsername', $newUsername);
        $stmt->bindParam(':newPassword', $newPassword);
        $stmt->bindParam(':currentUsername', $currentUsername);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($username) {
    
        $sql = "DELETE FROM $this->registration WHERE username = :username";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bindParam(':username', $username);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

   
      public function logout() {
        session_start(); 
        session_unset();
        session_destroy(); 
        return true;
    }
}
  
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>



    
</body>
</html>


    
</body>
</html>
