<?php
$host = 'localhost'; // or '127.0.0.1'
$dbname = 'billybet';
$username = 'root';
$password = '';

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