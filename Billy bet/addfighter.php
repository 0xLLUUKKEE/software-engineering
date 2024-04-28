<?php 
require_once 'config.php';
require 'events.php';
require 'common.php';
session_start();

if (isset($_POST['submit'])) {
    $fighterName = escape($_POST['name']);
    $rank = escape($_POST['rank']);
    //$fightID = escape($_POST['fightID']);

    $sql = "INSERT INTO fighter (`Fighter Name`, `Rank`) VALUES (:fighterName, :rank)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':fighterName', $fighterName);
    $statement->bindValue(':rank', $rank);
    //$statement->bindValue(':fightID', $fightID);

    $success = $statement->execute();

    if ($success) {

        echo '<script language="javascript">';
        echo 'alert("Fighter successfully added!");';
        echo 'window.location.href = "fighters.php";';
        echo '</script>';
        exit();
    } else {
        echo '<script language="javascript">';
        echo 'alert("Error adding fighter!")'; // Display error message if execution failed
        echo '</script>';
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

    <h1>Add Fighter</h1>
    <br><br><br><br>
    
    <form method="post">
        <label for="name">Fighter Name</label><br>
        <input type="text" name="name" id="name" required><br>
        <label for="rank">Rank</label><br>
        <input type="number" name="rank" id="rank" min="0" required><br>
        <!--<label for="fightID">Fight ID</label><br>
        <input type="number" name="fightID" id="fightID" min="0" required><br>-->
        <input type="submit" name="submit" value="Submit">
    </form>
    <br>
    <div class="topnav" id="myTopnav">
        <a href="fighters.php">Back</a>
    </div>
</body>
</html>
