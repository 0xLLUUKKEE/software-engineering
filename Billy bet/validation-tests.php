 <?php
 ////betpage.php bet placing validation//////////////////////////
 echo'</table>

        <form method="POST">
        <td>
        <label for="name">Amount Bet (minimum €' . $fight1->ticket->getPrice() . ')</label>
        <input type="number" required id="amount" name="amount" min="' . $fight1->ticket->getPrice() .'" value="15" class="big-input">

            
        <input type="Submit" name="Submit" id="bet" value="Place Bet" onclick="Submit">
        </form>';


    if (isset($_POST['Submit'])) {
    // ensures the user has enough in their balance to place the bet
    // if not, create a javascript alert telling the user they have insufficiant funds
    // otherwise, proceed with the bet
    if($_POST['amount'] > $curuser->getBalance()){
        echo '<script language="javascript">';
        echo 'alert("Insufficiant funds!");';
        echo '</script>';

    }
    else{
        $bet = new Bet($fight1, $curuser, $_POST['amount']);
        $curuser->updateBalanceInSession();

        echo '<script language="javascript">';
        echo 'alert("Bet successfully placed!");';
        $_SESSION['bet'] = serialize($bet);
        echo 'window.location.href = "ticket.php";';
        echo '</script>';
    }
}
?>


<?php
////signup.php email and password validation///////////
if (isset($_POST['submit'])) {
    // Check if the email already exists in the database
    $existing_email = $_POST['email'];
    $sql = "SELECT * FROM customer WHERE Email = :email";
    $statement = $pdo->prepare($sql);
    $statement->execute(array(':email' => $existing_email));
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    
    //if user with email exists create a javascript alert prompting the user to use another email
    if ($user != null) {
        echo '<script language="javascript">';
        echo 'alert("Email already exists! Please use a different email address.");';
        echo '</script>';
    } 

    //if the password entered is more than 8 characters, prompt the user to use a password less than 8 chars
    else if(strlen($_POST['password']) > 8){
        echo '<script language="javascript">';
        echo 'alert("Password must be under 8 characters!");';
        echo '</script>';
        
    }
    //otherwise, proceed with account creation
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
?>
                
<?php
////fighters.php////////////////////////////////////////////////
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['rank'])) {
        $ids = $_POST['id'];
        $ranks = $_POST['rank'];
        // Check if ranks are unique
        $uniqueRanks = array_unique($ranks);
        if (count($ranks) !== count($uniqueRanks)) {
            echo '<script language="javascript">';
            echo 'alert("Ranks must be unique! Please assign different ranks to fighters.");';
            echo 'window.history.back();'; // Redirect back to the form
            echo '</script>';
            exit(); // Stop further execution
        }
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

<?php
////addFighter.php//////////////////////////////////////////////

if (isset($_POST['submit'])) {

    $fighterName = escape($_POST['name']);
    $rank = escape($_POST['rank']);
    //query the database to see if any fighters exist the same name or rank as the ones the user input
    $sql = "SELECT * FROM `fighter` WHERE (`Fighter Name` = :name) OR (`Rank` = :rank)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':name', $fighterName);
    $statement->bindValue(':rank', $rank);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    //if user exists with the same name or rank, then prompt the user to enter unique name and rank
    if($user != null){
        echo '<script language="javascript">';
        echo 'alert("Fighter with that name or rank already exists! Please add a Fighter with a unique rank and name.");';
        echo '</script>';

    }
    else{
        //otherwise continue with fighter creation
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
}

?>

                
