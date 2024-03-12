<?php
require 'config.php';
$query = "SELECT * FROM fighter";
$result = $pdo->query($query);
$rows = $result->fetchAll(PDO::FETCH_ASSOC);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$query = "SELECT * FROM fighter";
$result = $pdo->query($query);
$rows = $result->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<head>
 	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Billy Bet</title>
    <link rel="stylesheet" href="css/style.css">   	
</head>
    
<body>
    <header><img src="images/20240228_1128511.gif" width="600" height="120"></header>
    
    <h1>Update Fighter Ranks</h1>
    <br>
    <br>
    <br>
    <br>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Rank</th>
        </tr>
        <?php
            foreach ($rows as $row) {
                echo "<tr>";
                echo "<td>" . $row['idFighter'] . "</td>";
                echo "<td>" . $row['Fighter Name'] . "</td>";
                echo "<td><input type='number' name='rank' min='1' value='" . $row['Rank'] . "'></td>";
                echo "<td><button onclick='updateRank(" . $row['idFighter'] . ")'>Update Rank</button></td>";
                echo "</tr>";
                
            }
        ?>
    </table>

    

    <br>
           
</body>
</html>