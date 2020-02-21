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
    <title>Consulta de cédula sospechoso</title>
</head>
<body>
<?php
//declaración de variables obtenidas mediante POST
$cedula=$_POST['cedula'];
//consulta a la tabla de cuentas
$consulta= $conn->prepare("SELECT * FROM suspects WHERE cedula= ? ");
$consulta->bindParam(1, $cedula);
if ($consulta->execute()){
    $count=$consulta->rowCount();
    if($count>0){
    echo "<p><h3>El total de veces que el ciudadano identificado con la cédula: $cedula ha estafado es igual a $count</h3></p>";
        echo "<table>";
        echo    "<tr>";
        echo    "<th>Expediente: </th>";
        echo    "<th>Nombre: </th>";
        echo    "</tr>";
        while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
        echo    "<tr>";
        echo    "<td>" . $row->expedient . "</td>";
        echo    "<td>" . $row->nombre . "</td>";
        echo    "</tr>";
        }
        echo    "</table>";
    } else {
        echo "<h3>No existen registros con el número de cédula: ".$cedula. "</h3>";
    }
} else {
    $consulta->error;
}
$conn=null;
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
</body>
</html>