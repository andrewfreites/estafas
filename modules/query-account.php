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
    <title>Consulta de cuentas</title>
</head>
<body>
<?php
//declaración de variables obtenidas mediante POST
$cuenta_sospechoso=$_POST['cuenta_sospechoso'];
//consulta a la tabla de cuentas
$consulta= $conn->prepare("SELECT * FROM accounts WHERE numero= ? ");
$consulta->bindParam(1, $cuenta_sospechoso);
if ($consulta->execute()){
$count = $consulta->rowCount();
if($count>0){
    echo "<h3>Casos del número de cuenta $cuenta_sospechoso</h3>";
    echo "<table>";
    echo    "<tr>";
    echo    "<th>Expediente: </th>";
    echo    "<th>Sospechoso:</th>";
    echo    "</tr>";
    /* obtener el array asociativo */
    while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
    echo    "<tr>";
    echo    "<td>" . $row->expedient . "</td>";
    echo    "<td>" . $row->sospechoso . "</td>";
    echo    "</tr>";
    }
    echo    "</table>";
} else {
    echo "<p>No existen registros con el número de cuenta: </p>".$cuenta_sospechoso;
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