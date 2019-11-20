<?php
//conexion realizada con 'mysqli'

//variables de la base de datos
$servername = "localhost"; //cambiar por el nombre del host del servidor a utilizar
$database = "db_denuncias"; //nombre de la base de datos
$username = "root"; // usuario asignado como administrador de la base de datos
$password = "password"; //clave del usuario asignado como administrador de la base de datos

//Crear conexion
$conn = new mysqli($servername, $username, $password, $database);

//revisar la conexion

if(!$conn) {
	die("Connection failed:" . mysqli_connect_error()); //muestra un mensaje de si la conexion falló y regresa el error
}
?>