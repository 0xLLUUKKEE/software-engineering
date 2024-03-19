<?php
require_once('config.php');
require 'events.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['rank'])) {
        $ids = $_POST['id'];
        $ranks = $_POST['rank'];

        // Update ranks in the database
        for ($i = 0; $i < count($ids); $i++) {
            $id = $ids[$i];
            $rank = $ranks[$i];

            $sql = "UPDATE fighter SET `Rank` = :rank WHERE idFighter = :id"; // Enclose "Rank" in backticks
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['rank' => $rank, 'id' => $id]);
        }

        echo '<script language="javascript">';
        echo 'alert("Ranks successfully updated!");';
        echo '</script>';
    } else {
        echo "ID and rank are required!";
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

    <h1>Update Fighter Ranks</h1>
    <br><br><br><br>

    <form method="post" action="">
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
                    echo "<td><input type='hidden' name='id[]' value='" . $row['idFighter'] . "'><input type='number' name='rank[]' min='1' value='" . $row['Rank'] . "'></td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <input type="submit" value="Update All Ranks">
    </form>
    <br>
    <br>
    <div class="topnav" id="myTopnav">
  
        
        <a href="addFighter.php">Add Fighter</a>
        <br>
        <a href="login.php">Log out</a>

    </div>
</body>
</html>
