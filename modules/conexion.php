<?php
//conexion realizada con 'mysqli'
//variables de la base de datos
$servername = "localhost";
$database = "db_denuncias";
$username = "root";
$password = "sabrent";

//Crear conexion
$conn = new mysqli($servername, $username, $password, $database);

//revisar la conexion

if($conn->connect_error) {
	die("Connection failed: " . $conn->connect_errno ." ." . $conn->connect_error); //muestra un mensaje de si la conexion falló y regresa el error
}
?>