<?php
require('config.php');
require_once('common.php');
require 'users.php';
session_start();
$user = unserialize($_SESSION['User']);
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check which button was clicked
    if (isset($_POST['add_balance'])) {
        // Call the addBalance() method on the user object
        $user->addBalance($_POST['quantity']);
        echo '<script>alert("Balance added successfully!");</script>';
    } elseif (isset($_POST['withdraw_balance'])) {
        // Call the withdrawBalance() method on the user object
        $user->withdrawBalance($_POST['quantity']);
        echo '<script>alert("Balance withdrawn successfully!");</script>';
    }
    // Serialize and store the updated user object in the session
    $_SESSION['User'] = serialize($user);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
 	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>BillyBet Gambling</title>
    <link rel="stylesheet" href="css/style.css">	

    </head>

<body>
    
    <header><img src="images/20240228_1128511.gif" width="600" height="130"></header>
    
       <div class="topnav" id="myTopnav">
  
   <center>
  <a href="index.php">Home Page</a>
  <a href="betpage.php">Bet Page</a>

       </center>
         
</div>
    
  <div class="container">
     
    
    
      <div class="left">
             <img src="images/buy-now-button.png" width="200" height="200">
         
      </div>
    

      <main>
          
      <h1>Your Balance:</h1>
          <br>
          <?php
                $user = unserialize($_SESSION['User']);
                $balance = $user->getBalance();
                echo "<h1>" . $balance . "</h1>";
                $_SESSION['User'] = serialize($user);
          ?>
          <br>
          <br>
        <form method="post">
            <label for="quantity"></label>
            <input type="number" id="quantity" name="quantity" min="0" value="0" class="big-input"><br><br>

            <input type="submit" name="add_balance" value="Add" class="big-input">
            <input type="submit" name="withdraw_balance" value="Withdraw" class="big-input">
        </form>
          
    

          
      </main>
      
      <div class="right">
   
          <img src="images/buy-now-button.png" width="200" height="200">
        
        
          <p>Place a Bet!!</p>
      <p></p>
      </div>
      
    </div>



</html>
   
            