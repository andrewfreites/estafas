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
//cross query
$consulta= $conn->prepare("SELECT suspects.nombre, suspects.cedula, complaints.monto, complaints.detail FROM suspects INNER JOIN complaints ON  complaints.expedient = suspects.expedient AND complaints.expedient= ? ORDER by complaints.fecha DESC");
$consulta->bindParam(1, $expediente);
if ($consulta->execute()){
    $count = $consulta->rowCount();
if($count>0){
    echo "<h3><p>Casos de: <h2>$expediente<h2><p></h3>";
    echo "<table>";
    echo    "<tr>";
    echo    "<th>Sospechoso: </th>";
    echo    "<th>Cedula: </th>";
    echo    "<th>Monto:</th>";
    echo    "<th>Detalle:</th>";
    echo    "</tr>";
    /* obtener el array asociativo */
    while ($row=$consulta->fetch(PDO::FETCH_OBJ)) {
    echo    "<tr>";
    echo    "<td>" . $row->nombre . "</td>";
    echo    "<td>" . $row->cedula . "</td>";
    echo    "<td>" . $row->monto . "</td>";
    echo    "<td>" . $row->detail . "</td>";
    echo    "</tr>";
    }
    echo    "</table>";
} else {
    echo "No existen registros con el expediente: ".$expediente;
}
} else {
    $consulta->error;
}
// Variable $count mantiene el resultado de la consulta, cuenta el numero de filas obtenidas

/* cerrar la conexión */
$conn=null;
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
</body>
</html>