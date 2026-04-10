<?php
$host = 'localhost';
$dbname = 'neuralchat_db';
$db_username = 'root'; // Change this if your local environment uses a different username
$db_password = '';     // Change this if your local environment has a password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $db_username, $db_password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
