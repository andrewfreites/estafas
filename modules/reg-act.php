<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<title>Registro de usuarios</title>
</head>
<body>
<?php
include 'conexion.php';
// consulta para revisar si el email ya existe
$checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ? ");
$checkEmail->bindParam(1, $_POST['email']);
if($checkEmail->execute()){
} else{
	$checkEmail->error;
}
// cuenta el numero de filas obtenidas
$count = $checkEmail->rowCount();
// si el resultado es 1 entonces el email existe
// se muestra un mensaje pidiendo iniciar sesión en la página de login
if ($count == 1) {
echo "<p>Ese email ya existe en la base de datos.</p>
<p><a href='../index.html'>Por favor inicie sesión aquí</a></p>";
} else {	
/*
si el correo no existe es creado el registro de usuario tomando las siguientes variables
*/
$name = $_POST['name'];
$email = $_POST['email'];
$pass = $_POST['password'];
// La función password_hash() convierte el password en un hash antes de enviarla a la base de datos
$passHash = password_hash($pass, PASSWORD_DEFAULT);
//Consulta para enviar el nombre, correo y el password hash a la base de datos
//(name,email,pass) son case sensitive y deben tener el mismo nombre que las columnas de la tabla de la base de datos
$query = $conn->prepare("INSERT INTO users (name, email, pass) VALUES (?, ?, ?)"); // Los values son las variables recogidas por POST del formulario
$query->bindParam(1, $name);
$query->bindParam(2, $email);
$query->bindParam(3, $passHash);
if ($query->execute()) {
	echo "<p>La cuenta ha sido creada satisfactoriamente</p>";
	header ("refresh:5;url=../index.php");
}
else {
	$query->error;
}
}
$conn=null;
?>
</body>
<script src="../js/countdown.js"></script>
<p>Serás llevado a iniciar sesión en <span id="countdown"></span> segundos, si no <a href="../index.html">haz click aquí</a></p>
</html>