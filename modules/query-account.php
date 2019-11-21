<?php
session_start();
header("Cache-control:private"); 
if($_SESSION['loggedin']=="") 
{ 
 header("Location:../index.html"); 
 exit; 
}
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consulta de cuentas</title>
</head>
<body>
<?php
//declaración de variables obtenidas mediante POST
$cuenta_sospechoso=$_POST['cuenta_sospechoso'];

if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}
//consulta a la tabla de cuentas
$consulta= "SELECT * FROM accounts WHERE numero='$cuenta_sospechoso' ORDER by casos DESC";
echo "<table>";
echo    "<tr>";
echo    "<th>Banco: </th>";
echo    "<th>Número: </th>";
echo    "<th>Casos:</th>";
echo    "</tr>";
if ($resultado = mysqli_query($conn, $consulta)) {
    /* obtener el array asociativo */
    while ($fila = mysqli_fetch_row($resultado)) {
    echo    "<tr>";
    echo    "<th>$fila[1]</th>";
    echo    "<th>$fila[2]</th>";
    echo    "<th>$fila[3]</th>";
    echo    "</tr>";
    echo "</table>";
    }

    /* liberar el conjunto de resultados */
    mysqli_free_result($resultado);
}
/* cerrar la conexión */
mysqli_close($conn);
?>
<a href="../consultas.php">Regresar a consultas</a>
</body>
</html>