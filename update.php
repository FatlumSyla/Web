<?php
session_start();
require_once('User.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentUsername = $_SESSION['username']; // Get current username from session
    $newUsername = $_POST['newUsername'];
    $newPassword = $_POST['newPassword'];

    $user = new User();

    if ($user->update($currentUsername, $newUsername, $newPassword)) {
        $_SESSION['username'] = $newUsername; // Update session with new username
        echo "User updated successfully!";
    } else {
        echo "User update failed!";
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

<form method="post" action="update.php">
    <input type="text" name="currentUsername" placeholder="Current Username" required />
    <input type="text" name="newUsername" placeholder="New Username" />
    <input type="password" name="newPassword" placeholder="New Password" />
    <button type="submit">Update</button>
</form>

    
</body>
</html>
