<?php 
require_once 'config.php';
require 'users.php';
require 'common.php';

    if (isset($_POST['submit'])) {
        // Check if the email already exists in the database
    $existing_email = $_POST['email'];
    $sql = "SELECT * FROM customer WHERE Email = :email";
    $statement = $pdo->prepare($sql);
    $statement->execute(array(':email' => $existing_email));
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user != null) {
        echo '<script language="javascript">';
        echo 'alert("Email already exists! Please use a different email address.");';
        echo '</script>';
    } 
    else if(strlen($_POST['password']) > 8){
        echo '<script language="javascript">';
        echo 'alert("Password must be under 8 characters!");';
        echo '</script>';
        
    }
    else {
        $new_user = array(
            "Email" => escape($_POST['email']),
            "Password" => escape($_POST['password']),
            "Name" => escape($_POST['name']),
            "Age" => escape($_POST['age']),
            "Balance" => 0
            );
        $sql = sprintf( "INSERT INTO %s (%s) values (%s)", "customer", implode(", ",
        array_keys($new_user)), ":" . implode(", :", array_keys($new_user)) );
        $statement = $pdo->prepare($sql);
        //$statement->execute($new_user);
        $success = $statement->execute($new_user);
        
        if ($success){
            $user = new Customer($row['Email'], $row['Password'], $row['Name'], $row['Age'], $row['Balance']);
            echo '<script language="javascript">';
            echo 'alert("Account successfully created!");';
            echo 'window.location.href = "login.php";';
            echo '</script>';
            exit();
        }
        else {
            echo '<script language="javascript">';
            echo 'alert("Error creating account!")'; // Display error message if execution failed
            echo '</script>';
        }
    }
}

function getSavedValue($key) {
    return isset($_COOKIE[$key]) ? htmlspecialchars($_COOKIE[$key]) : '';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billy Bet</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="localStorageHandling.js"></script>
    
</head>
<body>
    <header><img src="images/20240228_1128511.gif" width="600" height="120"></header>
    <h1>Sign Up!</h1>
    <form method="post">
        <label for="name">Full Name</label><br>
        <input type="text" name="name" id="name" value="<?php echo getSavedValue('Name'); ?>" required><br>
        
        <label for="age">Age</label><br>
        <input type="number" name="age" id="age" value="<?php echo getSavedValue('Age'); ?>" min='18' max='200' required><br>
        
        <label for="email">Email Address</label><br>
        <input type="email" name="email" id="email" value="<?php echo getSavedValue('Email'); ?>" required><br>
        
        <label for="password">Password</label><br>
        <input type="password" name="password" id="password" value="<?php echo getSavedValue('Password'); ?>"><br>
        
        <input type="submit" name="submit" value="Submit">
    </form>
    <div class="topnav" id="myTopnav">
        <a href="login.php">Already Have An Account?</a>
    </div>
    
</body>
</html>
