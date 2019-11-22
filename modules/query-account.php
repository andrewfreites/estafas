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
//guarda la consulta
$resultado = mysqli_query($conn, $consulta);
// Variable $count mantiene el resultado de la consulta, cuenta el numero de filas obtenidas
$count = mysqli_num_rows($resultado);
if($count>0){
if ($resultado = mysqli_query($conn, $consulta)) {
    echo "<table>";
    echo    "<tr>";
    echo    "<th>Banco: </th>";
    echo    "<th>Número: </th>";
    echo    "<th>Casos:</th>";
    echo    "</tr>";
    /* obtener el array asociativo */
    while ($fila = mysqli_fetch_row($resultado)) {
    echo    "<tr>";
    echo    "<td>$fila[1]</td>";
    echo    "<td>$fila[2]</td>";
    echo    "<td>$fila[3]</td>";
    echo    "</tr>";
    }
    echo    "</table>";
    /* liberar el conjunto de resultados */
    mysqli_free_result($resultado);
}
} else {
    echo "<p>aqui no está esa cuenta llave</p>";
}
/* cerrar la conexión */
mysqli_close($conn);
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
</body>
</html>