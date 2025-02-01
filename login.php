<?php
session_start();
require_once('User.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();

    $role = $user->login($username, $password); // Fix: Remove syntax errors

    if ($role) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role; // Store role in session

        if ($role === 'user') {
            header('Location: products.php'); 
        } else {
            header('Location: profili.php');
        }
        exit();
    } else {
        echo "Invalid username or password!";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    width: 650px;
    height: 500px;
    background-color: white;
    border-radius: 20px;
}

#ka {
    position: relative;
    margin-top: 20px;
    font-size: 3em;
    color: yellow;
}

#name, #username,#password {
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
#username {
    
    margin-top: 40px;
}
#name::placeholder, #username::placeholder,#password::placeholder {
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
    background-color: black;
    color: white;
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
        <nav class="navigation">
            
                <!-- <button onclick="location.href='signup.html'" class="signup-button">Signup</button> -->
            </div>
        </nav>
    </header>

    <div class="boksi">
        <div class="brenda" id="loginForm">
            <form action="login.php" method ="POST">
                <h1 id="ka">Login</h1>
                <div class="inputs-container">
                  
                    <input type="text" id="username" name ="username" placeholder="username">
                    <input type="password" id="password" name ="password" placeholder="Password">

                    
                </div>
                <button type="submit" class="regjister">Login</button>
            </form>

          <a href="signup-PA.html" style="text-decoration: none; color: black; position: relative; top: 20px;"> <strong><p id=tF>Don't have an account? Sign up here</p></strong></a> 
          
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
   
      
    
</body>
</html>

