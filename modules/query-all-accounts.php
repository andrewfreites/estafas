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
//consulta a la tabla de cuentas
$consulta= $conn->prepare("SELECT * FROM accounts");
if ($consulta->execute()){

} else{
    $consulta->error;
}
$count = $consulta->rowCount();
if($count>0){
echo "<h2>El total de cuentas registradas es de: ". $count ."</h2>"; 
    echo "<table>";
    echo    "<tr>";
    echo    "<th>Expediente:</th>";
    echo    "<th>Banco:</th>";
    echo    "<th>Número:</th>";
    echo    "<th>Sospechoso:</th>";
    echo    "</tr>";
    /* obtener el array asociativo */
    while ($row=$consulta->fetch(PDO::FETCH_OBJ)) {
    echo    "<tr>";
    echo    "<td>" . $row->expedient . "</td>";
    echo    "<td>" . $row->banco . "</td>";
    echo    "<td>" . $row->numero . "</td>";
    echo    "<td>" . $row->sospechoso . "</td>";
    echo    "</tr>";
    }
    echo    "</table>";
} else{
    echo "<h2>No existen cuentas registrados en la base de datos</h2>";
}
/* cerrar la conexión */
$conn=null;
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
</body>
</html>