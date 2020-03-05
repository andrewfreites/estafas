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
    <link rel="stylesheet" type="text/css" href="../css/all.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Consulta de expedientes</title>
</head>
<body>
<header>
    <nav class="topnav" id="myTopnav">
        <a href="../admin.php">Menú</a>
        <a href="../consultas.php" class="active">Consultas</a>
        <a href="../denuncia.php">Tomar denuncia</a>
        <a href="../modules/logout.php">Salir</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()"><i class="fa fa-bars"></i></a>
        </nav>
        <script src="../js/nav.js"></script>
</header>
<?php
$limit=20;
$expediente=$_POST['expediente'];
//cross query
$consulta= $conn->prepare("SELECT suspects.nombre, suspects.cedula, complaints.monto, complaints.detail FROM suspects INNER JOIN complaints ON  complaints.expedient = suspects.expedient AND complaints.expedient= ? ORDER by complaints.fecha DESC");
$consulta->bindParam(1, $expediente);
if ($consulta->execute()){
    $count = $consulta->rowCount();
    $total_pages= ceil($count/$limit);
    if (!isset($_GET['page'])){
        $page= 1;
    } else {
        $page= $_GET['page'];
    }
} else{
    $consulta->error;
}
$start=($page-1)*$limit;
$complaint= $conn->prepare("SELECT suspects.nombre, suspects.cedula, complaints.monto, complaints.detail FROM suspects INNER JOIN complaints ON  complaints.expedient = suspects.expedient AND complaints.expedient= ? ORDER by complaints.fecha DESC LIMIT ?,? ");
$complaint->bindParam(1, $expediente);
$complaint->bindParam(2,$start, PDO::PARAM_INT);
$complaint->bindParam(3,$limit, PDO::PARAM_INT);
if ($complaint->execute()){
    if($count>0){
    echo "<h3><p>Casos de: <h2>$expediente<h2><p></h3>";
    echo "<table>";
    echo    "<tr>";
    echo    "<th>Sospechoso: </th>";
    echo    "<th>Cedula: </th>";
    echo    "<th>Monto:</th>";
    echo    "<th>Detalle:</th>";
    echo    "</tr>";
    while ($row=$complaint->fetch(PDO::FETCH_OBJ)) {
    echo    "<tr>";
    echo    "<td>" . $row->nombre . "</td>";
    echo    "<td>" . $row->cedula . "</td>";
    echo    "<td>" . $row->monto . "</td>";
    echo    "<td>" . $row->detail . "</td>";
    echo    "</tr>";
    }
    echo    "<tr>";
    echo    "<td colspan="."4".">";
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
    echo "No existen registros con el expediente: ".$expediente;
}
} else {
    $complaint->error;
}
//close connection
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