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
<html lang="es">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Consulta de cuentas</title>
</head>
<body>
<?php
//declaración de variables obtenidas mediante POST
$telefono_sospechoso=$_POST['telefono_sospechoso'];

if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}
//consulta a la tabla de cuentas
$consulta= "SELECT * FROM phones WHERE numero='$telefono_sospechoso'";
//guarda la consulta
$resultado = mysqli_query($conn, $consulta);
// Variable $count mantiene el resultado de la consulta, cuenta el numero de filas obtenidas
$count = mysqli_num_rows($resultado);
if($count>0){
$veces= "SELECT veces FROM phones WHERE numero='$telefono_sospechoso'";
$resultVeces= mysqli_query($conn, $veces);
if ($veces>1){
echo "<p>El número de teléfono $telefono_sospechoso ha estafado $veces veces</p>". "<br>";
} else{
    echo "<p>El número de teléfono $telefono_sospechoso ha estafado una vez</p>". "<br>";
}
if ($resultado = mysqli_query($conn, $consulta)) {
    echo "<table>";
    echo    "<tr>";
    echo    "<th>Expediente: </th>";
    echo    "<th>Sospechoso:</th>";
    echo    "</tr>";
    /* obtener el array asociativo */
    while ($fila = mysqli_fetch_row($resultado)) {
    echo    "<tr>";
    echo    "<td>$fila[1]</td>";
    echo    "<td>$fila[3]</td>";
    echo    "</tr>";
    }
    echo    "</table>";
    /* liberar el conjunto de resultados */
    mysqli_free_result($resultado);
}
} else {
    echo "No existen registros con el número telefónico: ".$telefono_sospechoso;
}
/* cerrar la conexión */
mysqli_close($conn);
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
</body>
</html>