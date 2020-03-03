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
<html lang="en">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Consulta General de Teléfonos</title>
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
$limit=20; //Limit per page
$consulta= $conn->prepare("SELECT * FROM phones"); //redudant but used to get $count amount
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
$phones= $conn->prepare("SELECT * FROM phones ORDER BY id DESC LIMIT ?,? ");
$phones->bindParam(1,$start, PDO::PARAM_INT);
$phones->bindParam(2,$limit, PDO::PARAM_INT);
if ($phones->execute()){
if($count>0){
    echo "<h2>El total de números telefónicos registrados es de: ". $count ."</h2>"; 
    echo "<table>";
    echo    "<tr>";
    echo    "<th>Expediente:</th>";
    echo    "<th>Número:</th>";
    echo    "<th>Sospechoso:</th>";
    echo    "</tr>";
    /* obtener el array asociativo */
    while ($row = $phones->fetch(PDO::FETCH_OBJ)) {
    echo    "<tr>";
    echo    "<td>" . $row->expedient . "</td>";
    echo    "<td>" . $row->numero . "</td>";
    echo    "<td>" . $row->suspect . "</td>";
    echo    "</tr>";
    }
    echo    "<tr>";
    echo    "<td colspan="."3".">";
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
} else{
    echo "<h2>No existen teléfonos registrados en la base de datos</h2>";
}
} else {
    $phones->error;
}
/* cerrar la conexión */
$conn=null;
?>
<p><a href="../consultas.php">Regresar a consultas</a></p>
<script src="../js/outTime.js">
window.onload = setTimeout;
setTimeout(function(){
    window.location.href = "session_out.php";}, 15 * 60000);
<script src="../js/rest.js"></script>
<p id="countdown"></p>
</body>
</html>