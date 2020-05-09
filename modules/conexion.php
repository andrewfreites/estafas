<?php
//variables
$servername = "127.0.0.1";
$username = "root";
$password = "1234";
$database = "denuncias";
$port= "3308";

try {
$conn = new PDO("mysql:host=$servername; port=$port; dbname=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>