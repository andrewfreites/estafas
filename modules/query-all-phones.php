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
    <title>Consulta General de Teléfonos</title>
</head>
<body>
<?php
//consulta a la tabla de cuentas
$consulta= $conn->prepare("SELECT * FROM phones");
if ($consulta->execute()){
$count = $consulta->rowCount();
if($count>0){
    echo "<table>";
    echo    "<tr>";
    echo    "<th>Expediente:</th>";
    echo    "<th>Número:</th>";
    echo    "<th>Sospechoso:</th>";
    echo    "</tr>";
    /* obtener el array asociativo */
    while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
    echo    "<tr>";
    echo    "<td>" . $row->expedient . "</td>";
    echo    "<td>" . $row->numero . "</td>";
    echo    "<td>" . $row->suspect . "</td>";
    echo    "</tr>";
    }
    echo    "</table>";
} else{
    echo "<h2>No existen teléfonos registrados en la base de datos</h2>";
}
} else {
    $consulta->error;
}
/* cerrar la conexión */
$conn=null;
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
</body>
</html>