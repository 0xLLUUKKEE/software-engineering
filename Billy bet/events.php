<?php
//require 'users.php';

class Event {
    public $name;
    public $date;
    public $type;
    public $location;
    
    public function __construct($name, $date, $type, $location) {
        $this->name = $name;
        $this->date = $date;
        $this->type = $type;
        $this->location = $location;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getDate() {
        return $this->date;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function getLocation() {
        return $this->location;
    }
}

class Fighter {
    private $name;
    private $rank;
    
    public function __construct($name, $rank) {
        $this->name = $name;
        $this->rank = $rank;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getRank() {
        return $this->rank;
    }
}

class Ticket {
    private $price;
    
    public function __construct($price) {
        $this->price = $price;
    }
    
    public function getPrice() {
        return $this->price;
    }
}

class Fight {
    public $fighter1;
    public $fighter2;
    public $event;
    public $ticket;
    
    public function __construct(Fighter $fighter1, Fighter $fighter2, Event $event, Ticket $ticket) {
        $this->fighter1 = $fighter1;
        $this->fighter2 = $fighter2;
        $this->event = $event;
        $this->ticket = $ticket;
    }
    
    public function getFightDetails() {
        $details = "<h2>Fight Details:</h3>";
        $details .= "<h3>Event: {$this->event->getName()} ({$this->event->getDate()})</h3> <h3> fight type: {$this->event->getType()}</h3>";
        $details .= "<h3>Location: {$this->event->getLocation()}</h3><br>";
        $details .= "<h2>Fighters: </h2><h3>{$this->fighter1->getName()} (Rank: {$this->fighter1->getRank()}) vs {$this->fighter2->getName()} (Rank: {$this->fighter2->getRank()})</h3>";
        $details .= "<h3>Ticket Price (Minimum Bet): {$this->ticket->getPrice()}</h3><br>";
        return $details;
    }
    function calculate_bet_odds($rank_fighter1, $rank_fighter2) {
        // Generate random base odds
        $base_odds_fighter1 = mt_rand(50, 100) / 100; // Random number between 0.5 and 1.0
        $base_odds_fighter2 = mt_rand(50, 100) / 100; // Random number between 0.5 and 1.0
    
        // Apply rank-based adjustment
        if ($rank_fighter1 > $rank_fighter2) {
            $base_odds_fighter1 = 1.05; // 5% increase in odds
            $base_odds_fighter2= 0.95; // 5% decrease in odds
        } elseif ($rank_fighter2 > $rank_fighter1) {
            $base_odds_fighter1 = 0.95; // 5% decrease in odds
            $base_odds_fighter2= 1.05; // 5% increase in odds
        }
    
        return [$base_odds_fighter1 * 100, $base_odds_fighter2 * 100];
    }
}


class Bet{
    public $fight;
    public $customer;
    public $amountBet;
    public $winnings;
    public $receipt;
    public $hasWon;
    
    public function __construct(Fight $fight, Customer $customer, $amountBet){
        $this->fight = $fight;
        $this->customer = $customer;
        $this->amountBet = $amountBet;

        $customer->withdrawBalance($amountBet);
        if($this->hasWon()){
            $this->winnings = $amountBet * 2;
            $this->hasWon = "True";
        }
        else{
            $this->winnings = 0;
            $this->hasWon = "False";
        }

        $customer->addBalance($this->winnings);
        $_SESSION['User'] = serialize($this->customer);

        $this->receipt =  "<h1>TICKET RECEIPT:</h1><br>
        <h3>Customer Name: " . $this->customer->getName() . "</h3><br>" . $this->fight->getFightDetails() . 
        "<h3>Amount Bet: " . $this->amountBet . "</h3><h3>Won Bet: " . $this->hasWon . "</h3><h3>Winnings: " . $this->winnings . "</h3>";

    }

    public function getDetails(){
        return $this->receipt;
    }
    
    public function hasWon(){
        $hasWon = (bool) rand(0, 1); // random boolean
        return $hasWon;
    }
}

// Usage
/*
$fighter1 = new Fighter("John", 1);
$fighter2 = new Fighter("Jane", 2);
$eventType = $fighter1->getRank() == 1 || $fighter2->getRank() == 1 ? "Championship Fight" : "Fight Night";
$locations = ["Vegas", "Miami", "New York"];
$location = $locations[array_rand($locations)]; // Random location
$event = new Event($eventType, "2024-03-17", $eventType, $location);
$ticket = new Ticket(10); // Single ticket price
$fight = new Fight($fighter1, $fighter2, $event, $ticket);

// Get fight details
echo $fight->getFightDetails();
*/

?>