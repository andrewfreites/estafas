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
    <title>Consulta de expedientes</title>
</head>
<body>
<?php
//declaración de variables obtenidas mediante POST
$expediente=$_POST['expediente'];

if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}
//cross query
$consulta= "SELECT complaints.expedient, victim.nombre, victim.cedula, suspects.nombre, suspects.cedula, suspects.telefono, accounts.banco, accounts.numero, complaints.monto, DATE_FORMAT(complaints.fecha, '%d/%m/%Y'), complaints.detail FROM complaints, victim, suspects, accounts WHERE complaints.expedient=victim.expedient AND victim.expedient=suspects.expedient AND suspects.expedient=accounts.expedient AND accounts.expedient='$expediente' ORDER by complaints.fecha DESC";
//guarda la consulta
$resultado = mysqli_query($conn, $consulta);
// Variable $count mantiene el resultado de la consulta, cuenta el numero de filas obtenidas
$count = mysqli_num_rows($resultado);
if($count>0){
if ($resultado = mysqli_query($conn, $consulta)) {
    echo "<h3><p>Casos de: <h2>$expediente<h2><p></h3>";
    echo "<table>";
    echo    "<tr>";
    echo    "<th>Víctima: </th>";
    echo    "<th>Cédula: </th>";
    echo    "<th>Sospechoso:</th>";
    echo    "<th>Cédula:</th>";
    echo    "<th>Teléfono:</th>";
    echo    "<th>Banco:</th>";
    echo    "<th>Número:</th>";
    echo    "<th>Monto:</th>";
    echo    "<th>Fecha:</th>";
    echo    "<th>Detalle:</th>";
    echo    "</tr>";
    /* obtener el array asociativo */
    while ($fila = mysqli_fetch_row($resultado)) {
    echo    "<tr>";
    echo    "<td>$fila[1]</td>";
    echo    "<td>$fila[2]</td>";
    echo    "<td>$fila[3]</td>";
    echo    "<td>$fila[4]</td>";
    echo    "<td>$fila[5]</td>";
    echo    "<td>$fila[6]</td>";
    echo    "<td>$fila[7]</td>";
    echo    "<td>$fila[8]</td>";
    echo    "<td>$fila[9]</td>";
    echo    "<td>$fila[10]</td>";
    echo    "</tr>";
    }
    echo    "</table>";
    /* liberar el conjunto de resultados */
    mysqli_free_result($resultado);
}
} else {
    echo "No existen registros con el expediente: ".$expediente;
}
/* cerrar la conexión */
mysqli_close($conn);
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
</body>
</html>