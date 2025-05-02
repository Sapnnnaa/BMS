<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bankdb";

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Echo success message if connection is successful
    
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}
?>
