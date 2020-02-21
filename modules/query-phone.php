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
    <title>Consulta de teléfonos</title>
</head>
<body>
<?php
//declaración de variables obtenidas mediante POST
$telefono_sospechoso=$_POST['telefono_sospechoso'];
//consulta a la tabla de cuentas
$consulta= $conn->prepare("SELECT * FROM phones WHERE numero= ? ");
$consulta->bindParam(1, $telefono_sospechoso);
if($consulta->execute()){
    $count= $consulta->rowCount();
    if($count>0){
    echo "<p>La cantidad de veces que ha estafado el número de teléfono $telefono_sospechoso es: ".$count. "</p><br>";
        echo "<table>";
        echo    "<tr>";
        echo    "<th>Expediente: </th>";
        echo    "<th>Sospechoso:</th>";
        echo    "</tr>";
        /* objetc fetch mode */
        while ($row=$consulta->fetch(PDO::FETCH_OBJ)) {
        echo    "<tr>";
        echo    "<td>" . $row->expedient . "</td>";
        echo    "<td>" . $row->suspect . "</td>";
        }
        echo    "</table>";
    }
    else {
        echo "No existen registros con el número telefónico: ".$telefono_sospechoso;
    }
} else {
    $consulta->error;
}
//check if phone number exist
/* cerrar la conexión */
$conn=null;
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
</body>
</html>