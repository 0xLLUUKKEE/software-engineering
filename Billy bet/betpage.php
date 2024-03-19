
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
        <a href="index.php">Home Page</a>
        <a href="balance.php">Top Up Balnce</a>
      </div>
    
  <div class="container">
     
    
    
      <div class="left">
             <img src="images/buy-now-button.png" width="200" height="200">
         
      </div>

      <main>
        
        <?php
          require_once 'config.php';
          require_once 'common.php';
          require_once 'users.php';
          require_once 'events.php';
          session_start();
          $user = unserialize($_SESSION['User']);
          $balance = $user->getBalance();


          if (isset($_POST['Submit'])) {
            $bet = new Bet($fight1, $user, escape($_POST['email']));
            $_SESSION['bet'] = serialize($bet);

            echo '<script language="javascript">';
            echo 'alert("Fighter successfully added!");';
            echo 'window.location.href = "fighters.php";';
            echo '</script>';
          }

          
          
          
          echo "<h1> Balance: " . $balance ."</h1>";

          $sql = "SELECT `Fighter name` FROM fighter WHERE `Rank` = 1";
          $statement = $pdo->prepare($sql);
          $statement->execute();
          $fighterData = $statement->fetch(PDO::FETCH_ASSOC);
          $fighter1 = new Fighter($fighterData['Fighter name'], 1);
          
          
          $sql = "SELECT `Fighter name` FROM fighter WHERE `Rank` = 2";
          $statement = $pdo->prepare($sql);
          $statement->execute();
          $fighterData = $statement->fetch(PDO::FETCH_ASSOC);
          $fighter2 = new Fighter($fighterData['Fighter name'], 2);
          
         /* 
          // Query to select the fighter names where id doesn't equal 2
          $sql = "SELECT `Fighter name` FROM fighter WHERE id = 3";
          $statement = $pdo->prepare($sql);
          $fighter3 = new Fighter($statement, 1);

          // Query to select the fighter names with ranks 2 where id doesn't equal 2
          $sql = "SELECT `Fighter name` FROM fighter WHERE id = 4";
          $statement = $pdo->prepare($sql);
          $fighter4 = new Fighter($statement, 4);
*/
          // if ranks are 1 or 2 then set type to championship, otherwise set to fight night
          $eventType = $fighter1->getRank() == 1 || $fighter2->getRank() == 1 ? "Championship Fight" : "Fight Night";
          $locations = ["Vegas", "Miami", "New York"];
          
          $location1 = $locations[array_rand($locations)];
          $event1 = new Event($eventType, "2024-03-21", $eventType, $location1);
          $ticket1 = new Ticket(15); // Single ticket price
          $fight1 = new Fight($fighter1, $fighter2, $event1, $ticket1);
          //$fight1Odds = $fight1->calculate_bet_odds($fighter1,$fighter2);
          
/*         
          $location2 = $locations[array_rand($locations)]; // Random location
          $event2 = new Event($eventType, "2024-03-21", $eventType, $location2);
          $ticket2 = new Ticket(10); // Single ticket price
          $fight2 = new Fight($fighter3, $fighter4, $event2, $ticket2);
*/
            echo "<br>";
            echo "<h3>" . $event1->getName() . "</h3>";
            echo "<h4> Location: " . $event1->getLocation() . "</h4>";
            echo "<h4> Date: " . $event1->getDate() . "</h4>";
            echo "<table class='float' style='width:100%'>";
            echo"<tr>";
            echo"<td>Name</td>";
            echo"<td>Rank</td>";
            echo"<td>Ticket Price (Minimum Bet)</td>";
            echo"<td>Odds</td>";
            echo"</tr>";
            echo"<tr>";
            echo"<td>" . $fight1->fighter1->getName() . "</td>";
            echo"<td>" . $fight1->fighter1->getRank() . "</td>";
            echo"<td>" . $fight1->ticket->getPrice() . "</td>";
            echo"<td>" . $fight1->calculate_bet_odds($fighter1,$fighter2)[0] . "</td>";
            echo "</tr>";
            echo"<tr>";
            echo"<td>" . $fight1->fighter2->getName() . "</td>";
            echo"<td>" . $fight1->fighter2->getRank() . "</td>";
            echo"<td>" . $fight1->ticket->getPrice() . "</td>";
            echo"<td>" . $fight1->calculate_bet_odds($fighter1,$fighter2)[1] . "</td>";
            echo "</tr>";
            echo'</table>
                <form method="POST">
                <td>
                <label for="name">Amount Bet (minimum €' . $fight1->ticket->getPrice() . ')</label>
                <input type="number" required id="amount" name="amount" min="' . $fight1->ticket->getPrice() .'" value="15" class="big-input">

                  
                <input type="Submit" name="bet" id="bet" value="Place Bet" onclick="Submit">
                </form>';
                
                
            ?>  
        
          
    </main>
      
      <div class="right">
   
          <img src="images/buy-now-button.png" width="200" height="200">
        
        
          <p>Place a Bet!!</p>
      <p></p>
      </div>

      
    </div>
   
            