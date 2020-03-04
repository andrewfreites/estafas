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
    <link rel="stylesheet" type="text/css" href="css/all.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Administración</title>
</head>

<body>
    <header>
        <nav class="topnav" id="myTopnav">
            <a href="admin.php" class="active">Menú</a>
            <a href="consultas.php">Consultas</a>
            <a href="denuncia.php">Tomar denuncia</a>
            <a href="modules/logout.php">Salir</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
            </a>
        </nav>
        <script src="js/nav.js"></script>
    </header>
<?php
    echo "<h2>Bienvenido $_SESSION[name]</h2>";
?>
    <section class="menu">
        <a href="consultas.php"><img src="images/icono DB.svg" alt="Realizar consulta" class="opciones"></a>
        <a href="denuncia.php"><img src="images/icono Denuncia.svg" alt="Crear denuncia" class="opciones"></a>
    </section>
    <script src="js/outTime.js"></script>
    <script src="js/rest.js"></script>
    <p id="countdown"></p>
</body>
</html>