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
    <title>Listado de denuncias</title>
</head>
<body>
<?php
//query complaints table
$consulta= $conn->prepare("SELECT * FROM complaints ORDER by fecha DESC");
if ($consulta->execute()){
    $count = $consulta->rowCount();
    if($count>0){
    echo "<h2>La cantidad total de denuncias es de: ". $count."</h2>";
        echo "<table>";
        echo    "<tr>";
        echo    "<th>Expediente:</th>";
        echo    "<th>Monto:</th>";
        echo    "<th>Descripción:</th>";
        echo    "</tr>";
        /* obtener el array asociativo */
        while ($row=$consulta->fetch(PDO::FETCH_OBJ)) {
        echo    "<tr>";
        echo    "<td>" . $row->expedient . "</td>";
        echo    "<td>" . $row->monto . "</td>";
        echo    "<td>" . $row->detail . "</td>";
        echo    "</tr>";
        }
        echo    "</table>";
    } else{
        echo "<h2>No existen denuncias registradas</h2>";
    }
} else {
    $consulta->error;
}
$conn=null;
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
</body>
</html>
