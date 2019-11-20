<?php
  include 'conexion.php';
    
  // consulta para revisar si el email ya existe
	$checkEmail = "SELECT * FROM users WHERE email = '$_POST[email]' ";

	// Variable $result mantiene los datos de conexion
	$result = $conn-> query($checkEmail);

	// Variable $count mantiene el resultado de la consulta, cuenta el numero de filas obtenidas
	$count = mysqli_num_rows($result);

    // si el resultado es 1 entonces el email existe, y tomando esta condición nunca superará el número 1 al tan solo crear la primera cuenta
    // se muestra un mensaje pidiendo iniciar sesión en la página de login
	if ($count == 1) {
	echo "<p>Ese email ya existe en la base de datos.</p>
		    <p><a href='../index.html'>Por favor inicie sesión aquí</a></p>
		    ";
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
	$query = "INSERT INTO users (name, email, pass) VALUES ('$name', '$email', '$passHash')"; // Los values son las variables recogidas por POST del formulario
	if (mysqli_query($conn, $query)) {
		echo "<h3>Tu cuenta ha sido creada.</h3>
		<a href='../index.html'>Iniciar sesión</a>";		
		} else {
			echo "Error: " . $query . "<br>" . mysqli_error($conn);
		}	
	}	
    mysqli_close($conn);
?>