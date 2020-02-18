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
$uno=1;
//Victim Registration
$CheckVictim = $conn->prepare("SELECT * FROM victim WHERE cedula = ?"); // this one works fine
$CheckVictim->bind_param("i",$cedula_victima);
$CheckVictim->store_result();
if ($CheckVictim->execute()) {
  echo "success check victim ";
} else {
  echo $CheckVictim->error;
}
$countVictim = $CheckVictim->num_rows;
$CheckVictim->close();
// checking if the victim already exist and then insert 
if ($countVictim == 0) {
$QueryVictim=$conn->prepare("INSERT INTO victim (expedient, nombre, cedula, veces) VALUES (?, ?, ?, ?)");
$QueryVictim->bind_param("ssii", $expediente, $nombre_victima, $cedula_victima, $uno);
$QueryVictim->store_result();
if ($QueryVictim->execute()) {
echo "success insert new victim ";
} else {
    echo $QueryVictim->error;
}
} else{ //if false, then update the times he was scammed
$CheckVeces=$conn->prepare("SELECT veces FROM victim where cedula = ?");
$CheckVeces->bind_param("i", $cedula_victima);
$CheckVeces->store_result();
if ($CheckVeces->execute()) {
  echo "success check victim times ";
} else {
  echo $CheckVeces->error;
}
//mantiene los datos de la conexion
$ResultVeces= mysqli_query($conn,$CheckVeces);
//Guarda el valor de veces la fila de la tabla victim
$RowVictim= mysqli_fetch_assoc($ResultVeces);
//variable para guardar 'veces' de la tabla victim
$TimesVictim=$RowVictim['veces'];
$CheckVeces->close();
//valida las veces que ha sido estafada antes y muestra un mensaje segun la cantidad de veces
if($RowVictim['veces']>1){
echo "<script type='text/javascript'>alert('$mensaje_victima $TimesVictim $Veces')</script>";
} else{
echo "<script type='text/javascript'>alert('$mensaje_victima')</script>";
}
//suma una vez a las veces que ha sido estafado
$veces=$RowVictim['veces'] + 1;
//actualiza el campo $veces con un caso más
$QueryVictim= $conn->prepare("UPDATE victim SET veces= ? WHERE cedula= ?");
$QueryVictim->bind_param("ii",$veces,$cedula_victima);
$QueryVictim->store_result();
if ($QueryVictim->execute()){
  echo "success update times victim scammed ";
} else{
  echo $QueryVictim->error;
}
}
$QueryVictim->close();
//REGISTRO DE LA CUENTA DEL SOSPECHOSO
for($i=0;$i<$size_banks;$i++){
if($array_banco_sospechoso[$i]!="No Disponible"){
// consulta que revisa si la cuenta existe comparando el numero introducido con los existentes en la base de datos
$CheckAccount = $conn->prepare("SELECT * FROM accounts WHERE numero = ?");
$CheckAccount->bind_param("i",$array_numero_sospechoso[$i]);
$CheckAccount->store_result();
if($CheckAccount->execute()){
  echo "success account check ";
} else {
  echo $CheckAccount->error;
}
$count = $CheckAccount->num_rows;
// If counter is equal to 1 then, account exist
$CheckAccount->close(); 
if ($count == 1) {
$CheckCasos= $conn->prepare("SELECT casos FROM accounts WHERE numero = ?");
$CheckCasos->bind_param("i",$array_numero_sospechoso[$i]);
$CheckCasos->store_result();
if ($CheckCasos->execute()){
  echo "success check casos ";
} else{
  $CheckCasos->error;
}
$CheckCasos->close();
//guarda el resultado de la consulta
$ResultAccounts = mysqli_query($conn,$CheckCasos);
//Guarda el valor de la consulta
$RowAccount= mysqli_fetch_assoc($ResultAccounts);
// 'casos' from 'accounts'
$TimesAccount=$RowAccount['casos'];
//alert for repite
if ($RowAccount['casos']>1) {
  echo "<script type='text/javascript'>alert('$mensaje_cuenta $TimesAccount $Veces')</script>";
} else{
    echo "<script type='text/javascript'>alert('$mensaje_cuenta')</script>";
}
$casos=$RowAccount['casos'] + 1; //suma una denuncia al conteo de casos de la cuenta
$QueryAccounts= $conn->prepare("UPDATE accounts SET casos= ? WHERE numero= ? ");
$QueryAccounts->bind_param("ii", $casos, $array_numero_sospechoso[$i]);
$QueryAccounts->store_result();
if ($QueryAccounts->execute()) {
echo "success Query Accounts update ";
} else {
  echo $QueryAccounts->error;
}
} else{
$QueryAccounts= $conn->prepare("INSERT INTO accounts (expedient, banco, numero, casos, sospechoso) VALUES (?, ?, ?, ?, ?)");
$QueryAccounts->bind_param("ssiii", $expediente, $array_banco_sospechoso[$i], $array_numero_sospechoso[$i], $uno, $array_telefonos[$i]);
if ($QueryAccounts->execute()) {
  echo "success Query Accounts Insert ";
} else {
  echo $QueryAccounts->error;
}
$QueryAccounts->close();
}
}
}
//SUSPECT PHONE QUERY
for($i=0;$i<$size_phones;$i++){
if($array_telefonos[$i]!="No Disponible"){
$checkPhones = $conn->prepare("SELECT * FROM phones WHERE numero = ? ");
$checkPhones->bind_param("i",$array_telefonos[$i]);
$checkPhones->store_result();
if ($checkPhones->execute()){
  echo "success Check Phones";
} else{
  $checkPhones->error;
}
$countPhones= $checkPhones->num_rows;
$checkPhones->close();
if ($countPhones == 0){
$queryPhones= $conn->prepare("INSERT INTO phones (expedient, numero, suspect, veces) VALUES (?, ?, ?, ?)");
$queryPhones->bind_param("siii", $expediente, $array_telefonos[$i], $cedula_sospechoso, $uno);
$queryPhones->store_result();
if ($queryPhones->execute()){
  echo "success insert into phones ";
} else{
  echo $queryPhones->error;
}
$queryPhones->close();
} else { //CHECK TIMES THAT THE PHONE NUMBER SCAMMED BEFORE
$queryVecesPhone= $conn->prepare("SELECT veces FROM phones WHERE numero = ?");
$queryVecesPhone->bind_param("i", $array_telefonos[i]);
$queryVecesPhone->store_result();
if ($queryVecesPhone->execute()){
  echo "success query veces phone ";
} else{
  echo $queryVecesPhone->error;
}
$vecesPhoneResult= mysqli_query($conn, $queryVecesPhone);
$rowPhones= mysqli_fetch_assoc($vecesPhoneResult);
$queryVecesPhone->close();
if ($rowPhones['veces']>1){
  echo "<script type='text/javascript'>alert('$array_telefonos[i]: $mensaje_telefono $queryVecesPhone $Veces')</script>";
} else{
  echo "<script type='text/javascript'>alert('$array_telefonos[i]: $mensaje_telefono')</script>";
}
$vecesPhone= $rowPhones['veces'] + 1;
$updatePhone= $conn->prepare("UPDATE phones SET veces=$vecesPhone WHERE numero= ?");
$updatePhone->bind_param("i", $array_telefonos[i]);
$updatePhone->store_result();
if ($updatePhone->execute()){
  echo "success update phone veces ";
} else{
  $updatePhone->error;
}
$updatePhone->close();
}
}
}
//SUSPECT QUERY
$CheckSuspect = $conn->prepare("SELECT * FROM suspects WHERE cedula = ?");
$CheckSuspect->bind_param("i",$cedula_sospechoso);
$CheckSuspect->store_result();
if ($CheckSuspect->execute()){
  echo "success check suspect by cedula ";
} else {
  $CheckSuspect->error;
}
// mantiene el resultado de la consulta, contando el numero de filas obtenidas
$countSuspect = $CheckSuspect->num_rows;
// Si el resultado es 0 entonces el sospechoso no existe en la base de datos y se procede a registrar
$CheckSuspect->close();
if ($countSuspect == 0) {
//registra los datos de la victima en la tabla victim
$QuerySuspect=$conn->prepare("INSERT INTO suspects (expedient, nombre, cedula, veces) VALUES (?, ?, ?, ?)");
$QuerySuspect->bind_param("ssii", $expediente, $nombre_sospechoso, $cedula_sospechoso, $uno);
$QuerySuspect->store_result();
if ($QuerySuspect->execute()){
  echo "success query suspect ";
} else {
  $QuerySuspect->error;
}
$QuerySuspect->close();
} else{
//consulta la cantidad de veces que ha estafado ese numero de telefono
$CheckVecesSuspect=$conn->prepare("SELECT veces FROM suspects where cedula = ? ");
$CheckVecesSuspect->bind_param("i", $cedula_sospechoso);
$CheckVecesSuspect->store_result();
if ($CheckVecesSuspect->execute()){
  echo "success check veces suspect";
} else{
  $CheckVecesSuspect->error;
}
//guarda el resultado de la consulta
$ResultSuspect = mysqli_query($conn,$CheckVecesSuspect);
//valor de la fila
$RowSuspect= mysqli_fetch_assoc($ResultSuspect);
$CheckVecesSuspect->close();
//contabiliza y muestra un mensaje acorde a la cantidad de veces que ha estafado antes ese telefono
if ($RowSuspect['veces']>1) {
echo "<script type='text/javascript'>alert('El portador de la cédula: $cedula_sospechoso ha estafado antes $CheckVecesSuspect $Veces')</script>";
  } else{
echo "<script type='text/javascript'>alert('El portador de la cédula: $cedula_sospechoso ha estafado antes')</script>";
}
//suma una vez a las veces que ha sido estafado
$vecesSuspect=$RowSuspect['veces'] + 1;
//actualiza el campo $veces con un caso más
$QuerySuspect= $conn->prepare("UPDATE suspects SET veces='$vecesSuspect' WHERE cedula= ? ");
$QuerySuspect->bind_param("i", $cedula_sospechoso);
$QuerySUspect->store_result();
echo "<h2>Actualizada la cantidad de veces que ha estafado el sospechoso, debido a que es reincidente</h2>";
if ($QuerySuspect->execute()){
  echo "success update veces suspect scammed";
} else {
  $QuerySuspect->error;
}
}
$QueryComplaint=$conn->prepare("INSERT INTO complaints (expedient, detail, monto) VALUES (?, ?, ?)");
$QueryComplaint->bind_param("ssi", $expediente, $descripcion_denuncia, $monto);
$QueryComplaint->store_result();
if ($QueryComplaint->execute()){
  echo "success insert into complaints";
} else{
  $QueryComplaint->error;
}
$QueryComplaint->close();
header ("refresh:5;url=../denuncia.php");
//cerrar conexión
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
  <title>Procesando registro de denuncia</title>
</head>
<body>
<script src="../js/countdown.js"></script>
<p>Serás regresado automáticamente a la toma de denuncias en <span id="countdown"></span> segundos, si no <a href="../denuncia.php">haz click aquí</a></p>
</body>
</html>