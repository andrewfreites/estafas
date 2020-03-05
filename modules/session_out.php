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
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Sesión caducada</title>
</head>
<body>
<center>
<img src="../images/timeout.png" alt="time out image">
</center>
    <p><h3 style="text-align:center">Tu sesión ha caducado por seguridad debido a la inactividad, <a href="../index.html">Iniciar Sesión</h3></a></p>
</body>
</html>