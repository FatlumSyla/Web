<?php
session_start();
require_once('User.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    $user = new User();

    if ($user->delete($username)) {
        echo "User deleted successfully!";
    } else {
        echo "User deletion failed!";
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
    

<form method="post" action="delete.php">
    <input type="text" name="username" placeholder="Enter Username to Delete" required />
    <button type="submit">Delete User</button>
</form>

</body>
</html>
