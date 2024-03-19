
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
    
   
    
  <div class="container">
    
    
      <div class="left">
             <img src="images/buy-now-button.png" width="200" height="200">
      </div>

      <main>

            <?php
                require_once 'config.php';
                session_start();
                $bet = unserialize($_SESSION['bet']);
                echo $bet;
            ?>
        <a href="betpage.php">Bet Again?</a>
          
          
      </main>
      
      <div class="right">
   
          <img src="images/buy-now-button.png" width="200" height="200">
        
        
          <p>Place a Bet!!</p>
      <p></p>
      </div>
      
    </div>
   
   
            