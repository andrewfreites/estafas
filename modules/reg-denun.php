<?php
session_start();
header("Cache-control:private"); 
if($_SESSION['loggedin']=="") 
{ 
 header("Location:../index.html"); 
 exit; 
}
include 'conexion.php';
//variables from denuncia.php
$expediente=$_POST['expedient']; 
$cedula_sospechoso=$_POST['cedula_sospechoso']; 
$array_banco_sospechoso=$_REQUEST['banco_sospechoso'];
$array_numero_sospechoso=$_REQUEST['cuenta_sospechoso'];
$array_telefonos=$_REQUEST['telefono_sospechoso'];
$size_banks= sizeof($array_banco_sospechoso);
$size_phones= sizeof($array_telefonos);
$nombre_sospechoso=$_POST['nombre_sospechoso'];
$cedula_victima=$_POST['cedula_victima'];
$nombre_victima=$_POST['nombre_victima'];
$descripcion_denuncia=$_POST['descripcion_denuncia'];
$monto=$_POST['monto_estafado'];
$mensaje_victima="Esta persona ha sido estafada antes ";
$mensaje_cuenta="Esta cuenta ha estafado antes ";
$mensaje_telefono="Este numero de teléfono ha estafado antes ";
$Veces=" veces";
date_default_timezone_set("America/Caracas");
$date=date('d-m-Y');
//Victim Registration
$CheckVictim = $conn->prepare("SELECT * FROM victim WHERE cedula = ?"); // this one works fine
$CheckVictim->bindParam(1, $cedula_victima);
if ($CheckVictim->execute()) {
} else {
  echo $CheckVictim->error;
}
$countVictim= $CheckVictim->rowCount();
if ($countVictim==1){
  echo "<script type='text/javascript'>alert('$mensaje_victima')</script>";
} else if ($countVictim>1){
  echo "<script type='text/javascript'>alert('$mensaje_victima $countVictim $Veces')</script>";
}
$QueryVictim=$conn->prepare("INSERT INTO victim (expedient, nombre, cedula) VALUES (?, ?, ?)");
$QueryVictim->bindParam(1,$expediente);
$QueryVictim->bindParam(2,$nombre_victima);
$QueryVictim->bindParam(3,$cedula_victima);
if ($QueryVictim->execute()) {
  echo "<p><h3>Registrada correctamente la víctima</h3></p>";
} else {
    echo $QueryVictim->error;
}
//REGISTRO DE LA CUENTA DEL SOSPECHOSO
for($i=0;$i<$size_banks;$i++){
if($array_banco_sospechoso[$i]!="No Disponible"){
// consulta que revisa si la cuenta existe comparando el numero introducido con los existentes en la base de datos
$CheckAccount = $conn->prepare("SELECT * FROM accounts WHERE numero = ?");
$CheckAccount->bindParam(1, $array_numero_sospechoso[$i]);
if($CheckAccount->execute()){
} else {
  echo $CheckAccount->error;
}
$countAccount= $CheckAccount->rowCount();
if ($countAccount==1) {
  echo "<script type='text/javascript'>alert('$mensaje_cuenta')</script>";
} else if ($countAccount>1){
  echo "<script type='text/javascript'>alert('$mensaje_cuenta $countAccount $Veces')</script>";
}
$QueryAccounts= $conn->prepare("INSERT INTO accounts (expedient, banco, numero, sospechoso) VALUES (?, ?, ?, ?)");
$QueryAccounts->bindParam(1, $expediente);
$QueryAccounts->bindParam(2, $array_banco_sospechoso[$i]);
$QueryAccounts->bindParam(3, $array_numero_sospechoso[$i]);
$QueryAccounts->bindParam(4, $cedula_sospechoso);
if ($QueryAccounts->execute()) {
  echo "<p><h3>Registrada nueva cuenta bancaria</h3></p>";
} else {
  echo $QueryAccounts->error;
}
}
}
//SUSPECT PHONE QUERY
for($i=0;$i<$size_phones;$i++){
if($array_telefonos[$i]!="No Disponible"){
$checkPhones = $conn->prepare("SELECT * FROM phones WHERE numero = ? ");
$checkPhones->bindParam(1, $array_telefonos[$i]);
if ($checkPhones->execute()){
} else{
  $checkPhones->error;
}
$countPhones= $checkPhones->rowCount();
if ($countPhones==1){
  echo "<script type='text/javascript'>alert('$array_telefonos[i]: $mensaje_telefono')</script>";
} else if ($countPhones>1){
  echo "<script type='text/javascript'>alert('$array_telefonos[i]: $mensaje_telefono $countPhones $veces')</script>";
}
$queryPhones= $conn->prepare("INSERT INTO phones (expedient, numero, suspect) VALUES (?, ?, ?)");
$queryPhones->bindParam(1, $expediente);
$queryPhones->bindParam(2, $array_telefonos[$i]);
$queryPhones->bindParam(3, $cedula_sospechoso);
if ($queryPhones->execute()){
  echo "<p><h3>Registrado correctamente el número telefónico del sospechoso</h3></p>";
} else{
  echo $queryPhones->error;
}
}
}
//SUSPECT QUERY
if ($cedula_sospechoso!=""){
$CheckSuspect = $conn->prepare("SELECT * FROM suspects WHERE cedula = ?");
$CheckSuspect->bindParam(1, $cedula_sospechoso);
if ($CheckSuspect->execute()){
} else {
  $CheckSuspect->error;
}
$countSuspect= $CheckSuspect->rowCount();
if ($countSuspect == 1) {
  echo "<script type='text/javascript'>alert('El portador de la cédula: $cedula_sospechoso ha estafado antes')</script>";
}
else if ($countSuspect>1) {
  echo "<script type='text/javascript'>alert('El portador de la cédula: $cedula_sospechoso ha estafado antes $countSuspect $Veces')</script>";
}
//registra los datos de la victima en la tabla victim
$QuerySuspect=$conn->prepare("INSERT INTO suspects (expedient, nombre, cedula) VALUES (?, ?, ?)");
$QuerySuspect->bindParam(1, $expediente);
$QuerySuspect->bindParam(2, $nombre_sospechoso);
$QuerySuspect->bindParam(3, $cedula_sospechoso);
if ($QuerySuspect->execute()){
  echo "<p><h3>Registrado correctamente el sospechoso</h3></p>";
} else {
  $QuerySuspect->error;
}
} else {
  $QuerySuspect=$conn->prepare("INSERT INTO suspects (expedient, nombre, cedula) VALUES (?, ?, ?)");
$QuerySuspect->bindParam(1, $expediente);
$QuerySuspect->bindParam(2, $nombre_sospechoso);
$QuerySuspect->bindParam(3, $cedula_sospechoso);
if ($QuerySuspect->execute()){
  echo "<p><h3>Registrado correctamente el sospechoso</h3></p>";
} else {
  $QuerySuspect->error;
}
}
//COMPLAINT REGISTRATION
$QueryComplaint=$conn->prepare("INSERT INTO complaints (expedient, monto, detail, fecha) VALUES (?, ?, ?, ?)");
$QueryComplaint->bindParam(1, $expediente);
$QueryComplaint->bindParam(2, $monto);
$QueryComplaint->bindParam(3, $descripcion_denuncia);
$QueryComplaint->bindParam(4, $date);
if ($QueryComplaint->execute()){
  echo "<p><h3>Registrado nuevo expediente correctamente</h3></p>";
} else{
  $QueryComplaint->error;
}
header ("refresh:5;url=../denuncia.php");
//cerrar conexión
$conn=null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="../css/all.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
  <title>Procesando registro de denuncia</title>
</head>
<body>
<script src="../js/countdown.js"></script>
<p><h2>Serás regresado automáticamente a la toma de denuncias en <span id="countdown"></span> segundos, si no haz click <a href="../denuncia.php">aquí</a></h2></p>
</body>
</html>