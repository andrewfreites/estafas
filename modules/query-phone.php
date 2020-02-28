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
$limit=20;
$telefono_sospechoso=$_POST['telefono_sospechoso'];
//consulta a la tabla de cuentas
$consulta= $conn->prepare("SELECT * FROM phones WHERE numero= ? ");
$consulta->bindParam(1, $telefono_sospechoso, PDO::PARAM_INT);
if($consulta->execute()){
    $count= $consulta->rowCount();
    $total_pages= ceil($count/$limit);
    if (!isset($_GET['page'])){
        $page= 1;
    } else {
        $page= $_GET['page'];
    }
} else{
    $consulta->error;
}
$start= ($page-1)*$limit;
$phones= $conn->prepare("SELECT * FROM phones WHERE numero= ? ORDER BY id DESC LIMIT ?,? ");
$phones->bindParam(1, $telefono_sospechoso, PDO::PARAM_INT);
$phones->bindParam(2,$start, PDO::PARAM_INT);
$phones->bindParam(3,$limit, PDO::PARAM_INT);
if ($phones->execute()){
    if($count>0){
    echo "<p>La cantidad de veces que ha estafado el número de teléfono $telefono_sospechoso es: ".$count. "</p><br>";
        echo "<table>";
        echo    "<tr>";
        echo    "<th>Expediente: </th>";
        echo    "<th>Sospechoso:</th>";
        echo    "</tr>";
        /* objetc fetch mode */
        while ($row=$phones->fetch(PDO::FETCH_OBJ)) {
        echo    "<tr>";
        echo    "<td>" . $row->expedient . "</td>";
        echo    "<td>" . $row->suspect . "</td>";
        }
        echo    "</table>";
    if ($page>1 && $page<2){
        echo "<a href=?page=".($page-1).">anterior</a>";
    } else if ($page>=2){
        echo "<a href=?page=1>Inicio </a>";
        echo "<a href=?page=".($page-1).">anterior</a>";
    }
    for ($i=$page-2; $i<$page+3 ; $i++){
        if (($i!=$page && $i>1) && ($i<$total_pages))
    echo "<a href=?page=$i>". $i ." </a>";
    }
if ($page<($total_pages-1)){
    echo "<a href=?page=".($page+1).">Siguiente </a>";
    echo "<a href=?page=".($total_pages)."> Final</a>";
} else if ($page==($total_pages-1)){
    echo "<a href=?page=".($total_pages)."> Final</a>";
}
}   else {
        echo "No existen registros con el número telefónico: ".$telefono_sospechoso;
    }
} else {
    $phones->error;
}
//check if phone number exist
/* cerrar la conexión */
$conn=null;
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
<script>
window.onload = setTimeout;
setTimeout(function(){
    window.location.href = "session_out.php";}, 15 * 60000);
</script>
<script src="../js/rest.js"></script>
<p id="countdown"></p>
</body>
</html>