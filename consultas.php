<?php
session_start();
header("Cache-control:private"); 
if($_SESSION['loggedin']=="") 
{ 
 header("Location: index.html"); 
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
    <title>Consultas</title>
</head>
<body class="wrapper">
    <header>
        <nav>
            <ul>
                <a href="admin.html"><li>Menú</li></a>
                <a href="modules/logout.php"><li>Salir</li></a>
            </ul>
        </nav>
    </header>
    <!-- formulario para numero de telefono -->
    <p>Búsqueda por teléfono de sospechoso</p>
    <form action="modules/query-phone.php" method="POST">
    <label for="telefono_sospechoso">Teléfono: </label>
    <input type="tel" name="telefono_sospechoso" id="telefono_sospechoso" maxlength="11" required>
    <input type="submit" value="Buscar">
    </form>
    <!-- formulario para numero de cuenta -->
    <p>Búsqueda por número de cuenta</p>
    <form action="modules/query-account.php" method="post">
    <label for="cuenta_sospechoso">Cuenta: </label>
    <input type="text" name="cuenta_sospechoso" id="cuenta_sospechoso">
    <input type="submit" value="Buscar">
    </form>


</body>
</html>