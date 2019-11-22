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
    <p><h2>Consultas generales:</h2></p>
    <table class="table">
        <tr>
            <th> Cuentas </th>
            <th> Teléfonos </th>
            <th> Denuncias </th>
        </tr>
        <tr>
    <!-- Consulta general cuentas -->
    <form action="modules/query-all-accounts.php" method="POST">
    <td><input type="submit" value="Consultar"></td>
    </form>
    <!-- Consulta general teléfonos -->
    <form action="modules/query-all-phones.php" method="POST">
    <td><input type="submit" value="Consultar"></td>
    </form>
    <!-- Consulta general de denuncias -->
    <form action="modules/query-complaints.php" method="post">
    <td><input type="submit" value="Consultar"></td>
    </form>
    </tr>
    </table>
    <h2>Consultas detalladas</h2>
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