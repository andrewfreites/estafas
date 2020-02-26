<?php
//Inicia una nueva sesión o reanuda la existente 
    session_start(); 
//Remueve las variables de la sesión
    session_unset();
//Destruye toda la información registrada de una sesión
    session_destroy(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión caducada</title>
</head>
<body>
    <p><h3>Tu sesión ha caducado por seguridad debido a la inactividad, <a href="../index.html">Iniciar Sesión</h3></a></p>
</body>
</html>