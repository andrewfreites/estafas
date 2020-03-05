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
    <link rel="stylesheet" type="text/css" href="../css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Consulta General de Cuentas</title>
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
//consulta a la tabla de cuentas
$limit=20; //Limit per page
$consulta= $conn->prepare("SELECT * FROM accounts"); //redudant but used to get $count amount
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
$accounts=$conn->prepare("SELECT * FROM accounts ORDER BY id DESC LIMIT ?,? ");
$accounts->bindParam(1,$start, PDO::PARAM_INT);
$accounts->bindParam(2,$limit, PDO::PARAM_INT);
if($accounts->execute()){
if($count>0){
echo "<h2>El total de cuentas registradas es de: ". $count ."</h2>"; 
    echo "<table>";
    echo    "<tr class="."tableHeader".">";
    echo    "<th>Expediente:</th>";
    echo    "<th>Banco:</th>";
    echo    "<th>Número:</th>";
    echo    "<th>Sospechoso:</th>";
    echo    "</tr>";
	while ($row=$accounts->fetch(PDO::FETCH_OBJ)){ //Object Fetch
	echo    "<tr>";
    echo    "<td>" . $row->expedient . "</td>";
    echo    "<td>" . $row->banco . "</td>";
    echo    "<td>" . $row->numero . "</td>";
    echo    "<td>" . $row->sospechoso . "</td>";
    echo    "</tr>";
    }
    echo    "<tr>";
    echo    "<td colspan="."4".">";
    if ($page>1 && $page<2){
        echo "<a href=?page=".($page-1)."> anterior - </a>";
    } else if ($page>=2){
        echo "<a href=?page=1>inicio - </a>";
        echo "<a href=?page=".($page-1)."> anterior - </a>";
    }
    for ($i=$page-2; $i<$page+3 ; $i++){
        if (($i!=$page && $i>1) && ($i<$total_pages))
    echo "<a href=?page=$i>". $i ." - </a>";
    }
if ($page<($total_pages-1)){
    echo "<a href=?page=".($page+1)."> siguiente - </a>";
    echo "<a href=?page=".($total_pages)."> final</a>";
} else if ($page==($total_pages-1)){
    echo "<a href=?page=".($total_pages)."> final</a>";
}
echo    "</td>";
echo    "</tr>";
echo    "</table>";
} else{
    echo "<h3>No existen cuentas bancarias registradas</h3>";
}
} else {
    $accounts->error;
}
/* close connection */
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