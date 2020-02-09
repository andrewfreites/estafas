<?php
session_start();
header("Cache-control:private"); 
if($_SESSION['loggedin']=="") 
{ 
header("Location: ./modules/error.php");
 exit; 
}
?>
<!DOCTYPE html>
<html lang="es">
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
    <table width="320px">
        <tr>
            <th> Cuentas </th>
            <th> Teléfonos </th>
            <!-- <th> Denuncias </th> -->
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
    <!-- <form action="modules/query-complaints.php" method="post">
    <td><input type="submit" value="Consultar"></td>
    </form> -->
    </tr>
    </table>
    <h2>Consultas detalladas:</h2>
    <!-- formulario para numero de telefono -->
    <table width="320px">
    <tr><th><p>Por teléfono de sospechoso</p></th></tr>
    <form action="modules/query-phone.php" method="POST">
    <tr><td><label for="telefono_sospechoso">Teléfono: </label>
    <input type="tel" name="telefono_sospechoso" id="telefono_sospechoso" maxlength="11" style="width:150px" pattern="\d{11}" title="11 digitos, ejemplo 04141234567" required>
    <input type="submit" value="Buscar"></td>
    </form>
    </tr>
    </table>
    <!-- formulario para numero de cuenta -->
    <table width="320px">
    <tr><th><p>Por número de cuenta</p></th></tr>
    <form action="modules/query-account.php" method="POST">
    <tr><td><label for="cuenta_sospechoso">Cuenta: </label>
    <input type="text" name="cuenta_sospechoso" id="cuenta_sospechoso" maxlength="20" style="width:150px" pattern="\d{20}" title="20 digitos" required>
    <input type="submit" value="Buscar"></td>
    </form>
    </tr>
    </table>
    <!-- formulario para expediente -->
    <table width="320px">
    <tr><th><p>Por expediente</p></th></tr>
    <form action="modules/query-expedient.php" method="POST">
    <tr><td><label for="expediente">Expediente: </label>
    <input type="text" name="expediente" id="expediente" maxlength="15" style="width:150px" pattern="^[A-Za-z]-\d{2}-\d{4}-\d{5,6}" title="Ejemplo: K-12-1234-12345" required>
    <input type="submit" value="Buscar"></td>
    </form>
    </tr>
    </table>
    <!-- formulario para cedula -->
    <table width="320px">
    <tr><th><p>Por cédula</p></th></tr>
    <form action="modules/query-cedula.php" method="POST">
    <tr><td><label for="">Número: </label>
    <input type="text" name="cedula" id="cedula" maxlength="15" style="width:150px" pattern="\d{6,8}" required>
    <input type="submit" value="Buscar"></td>
    </form>
    </tr>
    </table>
</body>
</html>