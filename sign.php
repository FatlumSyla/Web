<?php

class UserRegistration {
    private $hostname = 'localhost:3307';
    private $username = 'root';
    private $password = '';
    private $database = 'ocardatabase';
    private $connection;

    public function __construct() {
        $this->connect();
    }

   
    private function connect() {
        try {
            $dsn = "mysql:host=$this->hostname;dbname=$this->database";
            $this->connection = new PDO($dsn, $this->username, $this->password);
           
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    
    public function checkUserExists($username) {
        $sql = "SELECT * FROM registration WHERE username = :username";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   
    public function insertUser($username, $password) {
        $sql = "INSERT INTO registration (username, password) VALUES (:username, :password)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

    public function getConnection() {
        return $this->connection;
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userRegistration = new UserRegistration();

    $username = $_POST['username'];
    $password = $_POST['password'];

  
    $user = $userRegistration->checkUserExists($username);

    if ($user) {
        echo "<span style='color: blue;'>User already exists!</span>";
    } else {
        
        $insertResult = $userRegistration->insertUser($username, $password);

        if ($insertResult) {
            
            header('Location: formulari.php');
            exit();
        } else {
            die("Error: Unable to insert user.");
        }
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.2/collection/components/icon/icon.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<style> 
body {
    background-color: black;
}
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', Arial, Helvetica, sans-serif;
}

header {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    background-color: transparent;
    color: #ffffff;
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

.boksi {
    position: relative;
    margin-top: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;

}

.brenda {
    text-align: center;
    width: 750px;
    height: 600px;
    background-color: white;
    border-radius: 20px;
}

#ka {
    position: relative;
    margin-top: 80px;
    color: yellow;
}

#name, #email, #password {
    font-size: 1em;
    margin-top: 10px;
    padding: 10px;
    text-align: left;
    vertical-align: top;
    box-sizing: border-box;
    width: 300px;
    height: 50px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#name {
    margin-top: 50px;
}
#name::placeholder, #email::placeholder, #password::placeholder {
    text-align: left;
    color: #999;
}

.inputs-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.regjister {
    padding: 8px 16px;
    width: 180px;
    height: 50px;
    font-size: 1em;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    background-color: #000000;
    color: rgb(255, 255, 255);
    transition: background-color 0.2s ease;
    position: relative;
    margin-top: 40px;
}

.regjister:hover {
    background-color: yellow;
}


footer{
    position: relative;
    bottom: -100px;
    background: black;
    width: 100%;
    
    left: 0;

 
  }
  footer::before{
    content: '';
    position: absolute;
    left: 0;
    top: 100px;
    height: 1px;
    width: 100%;
    background: #AFAFB6;
  }
  footer .content{
    max-width: 1250px;
    margin: auto;
    padding: 30px 40px 40px 40px;
  }
  footer .content .top{
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 50px;
  }
  .content .top .logo-details{
    color: #fff;
    font-size: 30px;
  }
  
  footer .content .link-boxes{
    width: 100%;
    display: flex;
    justify-content: space-between;
  }
  footer .content .link-boxes .box{
    width: calc(100% / 5 - 10px);
  }
  .content .link-boxes .box .link_name{
    color: #fff;
    font-size: 18px;
    font-weight: 400;
    margin-bottom: 10px;
    position: relative;
  }


  .content .link-boxes .box li a{
    color: #fff;
    font-size: 14px;
    font-weight: 400;
    text-decoration: none;
    opacity: 0.8;
    transition: all 0.4s ease
  }



  .link-boxes .box {
    list-style: none; 
    padding: 0; 
    margin: 0; 
}

 

  footer .bottom-details{
    width: 100%;
    background: #000000;
  }
  footer .bottom-details .bottom_text{
    max-width: 1250px;
    margin: auto;
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
  }
  .bottom-details .bottom_text span,
  .bottom-details .bottom_text a{
    font-size: 14px;
    font-weight: 300;
    color: #fff;
    opacity: 0.8;
    text-decoration: none;
  }
  .bottom-details .bottom_text a:hover{
    opacity: 1;
    text-decoration: underline;
  }
  .bottom-details .bottom_text a{
    margin-right: 10px;
  }

</style>

<body>
    <header>
        <a href="index.html" class="logo">OnlineCar</a>
        <nav class="navigation"></nav>
    </header>

    <div class="boksi">
        <div class="brenda">
          <form action ="sign.php" method ="POST" id="registerForm" >
            <h1 id="ka">Register a new account</h1>
            <div class="inputs-container">
                <input type="text" id="name" name="username" placeholder="Name" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="regjister">Register</button>
        </form>
            <a href="Login.html" style="text-decoration: none; color: black; position: relative; top: 20px;">
               <strong> <p id="tF">Already have an account? Log in</p></strong>
            </a>
        </div>
    </div>


    <footer>
        <div class="content">
          <div class="top">
            <div class="logo-details">
             
            </div>
           
          </div>
          <div class="link-boxes">
            <ul class="box">
              <li class="link_name" style="color: yellow;">OnlineCar</li>
              <li><a href="#">Home</a></li>
              <li><a href="contact.html">Contact us</a></li>
              <li><a href="#">About us</a></li>
              <li><a href="signup-PA.html">Get started</a></li>
            </ul>
        
           
           
         
          </div>
        </div>
        <div class="bottom-details">
          <div class="bottom_text">
            <span class="copyright_text">Copyright © 2024 <a href="#">OnlineCar.</a>All rights reserved</span>
            <span class="policy_terms">
              <a href="#">Privacy policy</a>
              <a href="#">Terms & condition</a>
            </span>
          </div>
        </div>
      </footer>
   
    <script>  document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const namePattern = /^[a-zA-Z\s]+$/;
    const isNameValid = namePattern.test(name);
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const isEmailValid = emailPattern.test(email);
    const isPasswordValid = password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password) && /[\W_]/.test(password);

   
        if (!isNameValid) {
            errorMessage += '- Name should contain at least a first name and last name (e.g. "Fatlum Syla").\n';
        }
        if (!isEmailValid) {
            errorMessage += '- Please enter a valid email (e.g. "example@example.com").\n';
        }
        if (!isPasswordValid) {
            errorMessage += '- Password must be at least 8 characters long, with an uppercase letter, a number, and a symbol.\n';
        }
        alert(errorMessage);
    }
});</script>
          

        
    </script>
</body>
</html>
