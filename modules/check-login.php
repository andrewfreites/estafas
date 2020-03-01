<?php
session_start();
  include 'conexion.php';
  // datos enviados desde index.html 
  $email = $_POST['email'];
  $password = $_POST['pass'];
  $query=$conn->prepare("SELECT * FROM users WHERE email = ? ");
  $query->bindParam(1, $email);
  if ($query->execute()){
    $count = $query->rowCount();
    // si el resultado es 1 entonces el email existe
    // se muestra un mensaje pidiendo iniciar sesión en la página de login
	if ($count == 1) {
    $row = $query->fetch(PDO::FETCH_OBJ);
    // guardar el hash del password
    $hash = $row->pass;
    /* 
    password_verify() verifica si la clave y el hash son iguales.
    */
    if (password_verify($_POST['pass'], $hash)) {	
        session_regenerate_id(true);
        $_SESSION['loggedin'] = true; //valor boolean de sesión iniciada
        //$row se trae el campo 'name' de la consulta de $result para mostrarlo como el nombre del usuario en la sesión
        $_SESSION['name'] = $row->name;
        $_SESSION['start'] = time();
        $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['userIp'] = $_SERVER['REMOTE_ADDR'];
        header("Location: ../admin.php");						
    } else {
        echo "<strong>Email o contraseña incorrectos!</strong>
        <p><a href='../index.html'><strong>Intente de nuevo!</strong></a></p>";			
    }
	} else {	
  echo "<p>No existe un usuario asociado al correo $email, por favor verifique la información</p>";
  echo "<p><a href='../index.html'><strong>Intente de nuevo!</strong></a></p>";
}
} else {
  $query->error;
}
$conn=null;
?>
</body>
</html>