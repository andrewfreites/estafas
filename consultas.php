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
                <a href="admin.php"><li>Menú</li></a>
                <a href="modules/logout.php"><li>Salir</li></a>
            </ul>
        </nav>
    </header>
    <!-- Consulta general -->
    <p>Consulta general de cuentas:</p>
    <form action="modules/query-all-accounts.php" method="POST">
    <input type="submit" value="Consultar">
    </form>
    <!-- formulario para numero de telefono -->
    <p>Búsqueda por teléfono de sospechoso</p>
    <form action="modules/query-phone.php" method="POST">
    <label for="telefono_sospechoso">Teléfono: </label>
    <input type="tel" name="telefono_sospechoso" id="telefono_sospechoso" maxlength="11" required>
    <input type="submit" value="Buscar">
    </form>
    <!-- formulario para numero de cuenta -->
    <p>Búsqueda por número de cuenta</p>
    <form action="modules/query-account.php" method="POST">
    <label for="cuenta_sospechoso">Cuenta: </label>
    <input type="text" name="cuenta_sospechoso" id="cuenta_sospechoso" maxlength="20">
    <input type="submit" value="Buscar">
    </form>


</body>
</html>