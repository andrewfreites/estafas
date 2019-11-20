<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Revisar usuario y crear sesión</title>
</head>
<body>
<?php
  include 'conexion.php';
  // datos enviados desde index.html 
  $email = $_POST['email'];
  $password = $_POST['pass'];
  
  // consulta a la base de datos
  $result = mysqli_query($conn, "SELECT email, pass, name FROM users WHERE email = '$email'");
  
  // guardar el resultado de la consulta
  $row = mysqli_fetch_assoc($result);
  
  // guardar el hash del password
  $hash = $row['pass'];
  
  /* 
  password_Verify() verifica si la clave y el hash son iguales. $_SESSION['expire'] = $_SESSION['start'] + (1 * 60)
  define el tiempo en que expira la sesión. Cambiar el 1 por la cantidad de minutos que desee para la sesión.
  */
  if (password_verify($_POST['pass'], $hash)) {	
      
      $_SESSION['loggedin'] = true; //valor boolean de sesión iniciada
      //$row se trae el campo 'name' de la consulta de $result para mostrarlo como el nombre del usuario en la sesión
      $_SESSION['name'] = $row['name'];
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + (1 * 60);
      header("Location: ../admin.php");						
  } else {
      echo "<strong>Email o contraseña incorrectos!</strong>
      <p><a href='../index.html'><strong>Intente de nuevo!</strong></a></p></div>";			
  }
?>
</body>
</html>