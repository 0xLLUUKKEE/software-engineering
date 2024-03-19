<?php
class User {
    
    public $email;
    public $password;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }
    public function getEmail(){
        return $this->email;
    }

}

class Customer extends User {
    public $balance;
    public $name;
    public $age;
    
    public function __construct($email, $password, $name, $age, $balance) {
        parent::__construct($email, $password);
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->age = $age;
        $this->balance = $balance;
    }

    public function getName(){
        return $this->name;
    }

    public function addBalance($amount) {
        $this->balance += $amount;
        $this->updateBalanceInDatabase();
    }
    
    public function withdrawBalance($amount) {
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
            $this->updateBalanceInDatabase();
        } else {
            echo "Insufficient funds\n";
        }
    }
    
    public function getBalance() {
        return $this->balance;
    }

    private function updateBalanceInDatabase() {
        require('config.php');
        try {
            // Prepare SQL statement
            $sql = "UPDATE customer SET balance = :balance WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['balance' => $this->balance, 'email' => $this->email]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

class Admin extends User {
    public function __construct($email, $password){
        parent::__construct($email, $password);
    }

}
/*
$customer1 = new Customer("Alice", "alice@example.com");
$customer1->addBalance(1000);
echo $customer1->getBalance() . "\n"; // Output: 1000
$customer1->withdrawBalance(500);
echo $customer1->getBalance() . "\n"; // Output: 500

$admin1 = new Admin("Bob", "bob@example.com");
$admin1->addBalance(2000);
echo $admin1->getBalance() . "\n"; // Output: 2000
$admin1->withdrawBalance(500);
echo $admin1->getBalance() . "\n"; // Output: 1500
*/
?>