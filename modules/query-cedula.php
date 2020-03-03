<?php
session_start();
header("Cache-control:private");
include 'checkUser.php'; 
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
$limit=20;
$cedula=$_POST['cedula'];
$consulta= $conn->prepare("SELECT * FROM suspects WHERE cedula= ? ");
$consulta->bindParam(1, $cedula, PDO::PARAM_INT);
if ($consulta->execute()){
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
$suspects= $conn->prepare("SELECT * FROM suspects WHERE cedula= ? LIMIT ?,? ");
$suspects->bindParam(1, $cedula, PDO::PARAM_INT);
$suspects->bindParam(2,$start, PDO::PARAM_INT);
$suspects->bindParam(3,$limit, PDO::PARAM_INT);
if ($suspects->execute()){
    if($count>0){
    echo "<p><h3>El total de veces que el ciudadano identificado con la cédula: $cedula ha estafado es igual a $count</h3></p>";
        echo "<table>";
        echo    "<tr>";
        echo    "<th>Expediente: </th>";
        echo    "<th>Nombre: </th>";
        echo    "</tr>";
        while ($row = $suspects->fetch(PDO::FETCH_OBJ)) {
        echo    "<tr>";
        echo    "<td>" . $row->expedient . "</td>";
        echo    "<td>" . $row->nombre . "</td>";
        echo    "</tr>";
        }
        echo    "<tr>";
        echo    "<td colspan="."2".">";
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
        echo    "</td>";
        echo    "</tr>";
        echo    "</table>";
} else {
    echo "<h3>No existen registros con el número de cédula: ".$cedula. "</h3>";
}
} else {
    $suspects->error;
}
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