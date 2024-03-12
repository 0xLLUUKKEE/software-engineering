<?php 
    require 'config.php';
    require 'common.php';
    if (isset($_POST['submit'])) {
        $new_user = array(
            "name" => escape($_POST['name']),
            "age" => escape($_POST['age']),
            "email" => escape($_POST['email']),
            "password" => escape($_POST['password'])
            );
        $sql = sprintf( "INSERT INTO %s (%s) values (%s)", "customer", implode(", ",
        array_keys($new_user)), ":" . implode(", :", array_keys($new_user)) );
        $statement = $pdo->prepare($sql);
        $statement->execute($new_user);
    }
    if (isset($_POST['submit']) && $statement){
        echo '<script language="javascript">';
        echo 'alert("Account succesfully created!")';
        echo '</script>';   
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
    
    <h1>Sign Up!</h1>
    <br>
    <br>
    <br>
    <br>
    
    <form method="post">
        <label for="name">Full Name</label>
        <br>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="age">Age</label>
        <br>
        <input type="number" name="age" id="age" min='1' max='200' required>
        <br>
        <label for="email">Email Address</label>
        <br>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password</label>
        <br>
        <input type="text" name="password" id="password">
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>

</html>