<?php
//variables
$servername = "127.0.0.1";
$username = "root";
$password = "12345";
$database = "denuncias";
$port= "3308";

//create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

//check connection
if($conn->connect_error) {
	die("Connection failed error: " . $conn->connect_errno .". " . $conn->connect_error);
}
?>