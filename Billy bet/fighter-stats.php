<?php
require_once('config.php');
require 'events.php';

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

       <div class="topnav" id="myTopnav">
  
        <center>
        <a href="index.php">Home Page</a>
        <a href="betpage.php">Bet Page</a>
        <a href="balance.php">Balance</a>

            </center>
         
    </div>
    <h1>Fighter Stats</h1>
    <br><br><br><br>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Rank</th>
            </tr>
            <?php
                require('config.php');
                require('users.php');
                session_start();
                
                // Fetch fighter data
                $query = "SELECT * FROM fighter";
                $result = $pdo->query($query);
                $rows = $result->fetchAll(PDO::FETCH_ASSOC);
                //echo $fighterArray[1]->getName();
                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['idFighter'] . "</td>";
                    echo "<td>" . $row['Fighter Name'] . "</td>";
                    echo "<td>". $row['Rank'] . "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </form>
    <br>
    <br>
    <div class="topnav" id="myTopnav">
  
        
        <br>

    </div>
</body>
</html>
