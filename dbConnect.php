<?php
class DbConnect {
    private $host = 'localhost:3307';
    private $dbname = 'onlinecar2';
    private $user = 'root';
    private $pass = '';

    public function connect() {
        try {
            $conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           return $conn;
        } catch (PDOException $e) {
            echo 'database error: ' . $e->getMessage();
        }
    }
}


?>
