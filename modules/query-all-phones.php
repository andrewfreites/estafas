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
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Consulta General de Cuentas</title>
</head>
<body>
<?php
if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}
//consulta a la tabla de cuentas
$consulta= "SELECT * FROM suspects ORDER by veces DESC";
//guarda la consulta
$resultado = mysqli_query($conn, $consulta);
// Variable $count mantiene el resultado de la consulta, cuenta el numero de filas obtenidas
$count = mysqli_num_rows($resultado);
if($count>0){
if ($resultado = mysqli_query($conn, $consulta)) {
    echo "<table>";
    echo    "<tr>";
    echo    "<th>Nombre:</th>";
    echo    "<th>Cédula:</th>";
    echo    "<th>Teléfono:</th>";
    echo    "<th>Email:</th>";
    echo    "<th>Casos:</th>";
    echo    "</tr>";
    /* obtener el array asociativo */
    while ($fila = mysqli_fetch_row($resultado)) {
    echo    "<tr>";
    echo    "<td>$fila[1]</td>";
    echo    "<td>$fila[2]</td>";
    echo    "<td>$fila[3]</td>";
    echo    "<td>$fila[4]</td>";
    echo    "<td>$fila[5]</td>";
    echo    "</tr>";
    }
    echo    "</table>";
    /* liberar el conjunto de resultados */
    mysqli_free_result($resultado);
}
}else{
    echo "No existen teléfonos registrados en la base de datos";
}
/* cerrar la conexión */
mysqli_close($conn);
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
</body>
</html>