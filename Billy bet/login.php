<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require('config.php');
require_once('common.php');
require 'users.php';
session_start();

// Define $email and $password variables outside of the if block
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if(isset($_POST['submit'])){
    /* Check if the form's username and password matches */
    $sql = "SELECT *
            FROM customer
            WHERE email = :email AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => $password]);

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Pass the fetched data to the Customer class constructor
        $user = new Customer($row['Email'], $row['Password'], $row['Name'], $row['Age'], $row['Balance']);
        $_SESSION['User'] = serialize($user);

        echo '<script language="javascript">';
        echo 'alert("Login Successful!");';
        echo 'window.location.href = "balance.php";';
        echo '</script>';
    }
    else {
        $sql = "SELECT *
                FROM admin WHERE email = :email AND password = :password";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email, 'password' => $password]);
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
            // Pass the fetched data to the Admin class constructor
            $user = new Admin($row['Email'], $row['Password']);
            $_SESSION['User'] = serialize($user);
        
            echo '<script language="javascript">';
            echo 'alert("Admin Login Successful!");';
            echo 'window.location.href = "fighters.php";';
            echo '</script>';
            exit();
        
        } 
        else {
            echo '<script language="javascript">';
            echo 'alert("Incorrect username/password");';
            echo '</script>'; 
        } 
    }    

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billy Bet</title>
    <link rel="stylesheet" href="css/style.css">   
</head>

<body>
    <header><img src="images/20240228_1128511.gif" width="600" height="120"></header>
    
    <h1>Log in</h1>
    <br><br><br><br>
    
    <form method="post">
        <label for="email">Email Address</label><br>
        <input type="email" name="email" id="email" required><br>
        <label for="password">Password</label><br>
        <input type="text" name="password" id="password"><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>