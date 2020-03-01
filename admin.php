<?php
session_start();
header("Cache-control:private");
include 'modules/checkUser.php'; 
if($_SESSION['loggedin']=="") 
{ 
 header("Location: ./modules/error.php"); 
 exit; 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Administración</title>
</head>

<body>
    <header>
        <nav>
            <ul>
            <?php
            echo "<li>Bienvenido $_SESSION[name]</li>";
            ?>
                <a href="modules/logout.php"><li>Salir</li></a>
            </ul>
        </nav>
    </header>
    <main role="main">
        <h2>Seleccione una opción:</h2>
        <a href="consultas.php"><img src="images/icono DB.svg" alt="Realizar consulta"></a>
        <a href="denuncia.php"><img src="images/icono Denuncia.svg" alt="Crear denuncia"></a>
    </main>
    <script src="js/outTime.js"></script>
    <script src="js/rest.js"></script>
    <p id="countdown"></p>
</body>
</html>