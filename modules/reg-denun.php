<?php
session_start();
header("Cache-control:private"); 
if($_SESSION['loggedin']=="") 
{ 
 header("Location:../index.html"); 
 exit; 
}

include 'conexion.php';
//Declaración de variables tomadas por post desde denuncia.php
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

//REGISTRO DE DATOS DE VICTIMA

  // consulta que revisa si la victima existe en la base de datos
  $CheckVictim = "SELECT * FROM victim WHERE cedula = '$_POST[cedula_victima]' ";

  // Variable $result mantiene los datos de conexion
  $resultVictim = $conn-> query($CheckVictim);

  // mantiene el resultado de la consulta, contando el numero de filas obtenidas
  $countVictim = mysqli_num_rows($resultVictim);

  // Si el resultado es 0 entonces la victima no existe en la base de datos y se procede a registrar 
  if ($countVictim == 0) {
    //registra los datos de la victima en la tabla victim
    $QueryVictim="INSERT INTO victim (expedient, nombre, cedula, veces) VALUES ('$expediente', '$nombre_victima', '$cedula_victima', 1)";
    //Comprobación de las operaciones con la base de datos
    if (mysqli_query($conn, $QueryVictim)) {
echo "<h3>Se registraron correctamente los datos de la victima.</h3>";
} else {
    echo "Error en datos de la victima: " . $QueryVictim . "<br>" . mysqli_error($conn);
}
  } else{ //si no, solo se actualiza el numero de veces que ha sido estafada
    //consulta la cantidad de veces que ha sido estafado
    $CheckVeces="SELECT veces FROM victim where cedula = '$_POST[cedula_victima]' ";
    //mantiene los datos de la conexion
    $ResultVeces= mysqli_query($conn,$CheckVeces);
    //Guarda el valor de veces la fila de la tabla victim
    $RowVictim= mysqli_fetch_assoc($ResultVeces);
    //variable para guardar 'veces' de la tabla victim
    $TimesVictim=$RowVictim['veces'];
    //valida las veces que ha sido estafada antes y muestra un mensaje segun la cantidad de veces
    if($RowVictim['veces']>1){
echo "<script type='text/javascript'>alert('$mensaje_victima $TimesVictim $Veces')</script>";
    } else{
echo "<script type='text/javascript'>alert('$mensaje_victima')</script>";
    }
    //suma una vez a las veces que ha sido estafado
    $veces=$RowVictim['veces'] + 1;
    //actualiza el campo $veces con un caso más
    $QueryVictim= "UPDATE victim SET veces='$veces' WHERE cedula='$_POST[cedula_victima]'";
    echo "<p>Se actualizó datos de la victima debido a que ya ha realizado denuncias anteriormente</p>";
    //Comprobación de las operaciones con la base de datos
    if (mysqli_query($conn, $QueryVictim)) {
echo "<h3>Se registraron correctamente los datos de la victima.</h3>";
} else {
    echo "Error en datos de la victima: " . $QueryVictim . "<br>" . mysqli_error($conn);
}
  }

//REGISTRO DE LA CUENTA DEL SOSPECHOSO
for($i=0;$i<$size_banks;$i++){
  if($array_banco_sospechoso[$i]!="No Disponible"){
  // consulta que revisa si la cuenta existe comparando el numero introducido con los existentes en la base de datos
	$CheckAccount = "SELECT * FROM accounts WHERE numero = '$array_numero_sospechoso[$i]'";
	// Variable $result mantiene los datos de conexion
	$result = $conn-> query($CheckAccount);

	// mantiene el resultado de la consulta, contando el numero de filas obtenidas
	$count = mysqli_num_rows($result);

    // Si el resultado es 1 entonces la cuenta existe, 
    if ($count == 1) {
  //guarda la consulta de los casos en la tabla cuentas
  $CheckCasos= "SELECT casos FROM accounts WHERE numero = '$array_numero_sospechoso[$i]'";
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
  $QueryAccounts= "UPDATE accounts SET casos='$casos' WHERE numero= '$array_numero_sospechoso[$i]'";
  echo "<h2>Se actualizó el numero de casos de estafa asociados a la cuenta, ya que es reincidente</h2>";
  if (mysqli_query($conn, $QueryAccounts)) {
    echo "<h3>Se registraron correctamente los datos de la cuenta.</h3>";
    } else {
  echo "Error en datos de cuenta: " . $QueryAccounts . "<br>" . mysqli_error($conn);
    }
    } else{
  $QueryAccounts= "INSERT INTO accounts (expedient, banco, numero, casos, sospechoso) VALUES ('$expediente','$array_banco_sospechoso[$i]', '$array_numero_sospechoso[$i]', 1,'$array_telefonos[$i]')";
  if (mysqli_query($conn, $QueryAccounts)) {
    echo "<h3>Se registraron correctamente los datos de la cuenta.</h3>";
    } else {
  echo "Error en datos de cuenta: " . $QueryAccounts . "<br>" . mysqli_error($conn);
    }
    }
}
}
//SUSPECT PHONE QUERY
for($i=0;$i<$size_phones;$i++){
if($array_telefonos[$i]!="No Disponible"){
$checkPhones = "SELECT * FROM phones WHERE numero = '$array_telefonos[$i]'";
$resultPhones= $conn-> query($checkPhones);
$countPhones= mysqli_num_rows($resultPhones);
if ($countPhones == 0){
  $queryPhones= "INSERT INTO phones (expedient, numero, suspect, veces) VALUES ('$expediente','$array_telefonos[$i]', '$cedula_sospechoso', 1)";
  if (mysqli_query($conn,$queryPhones)){
    echo "<h3> Se registró correctamente teléfonos del sospechoso</h3>";
  } else{
    echo "<h3> Error en registro de teléfono del sospechoso: " . $queryPhones . "<br>" . mysqli_error($conn);
  }
} else { //CHECK TIMES THAT THE PHONE NUMBER SCAMMED BEFORE
  $queryVecesPhone= "SELECT veces FROM phones WHERE numero = '$array_telefonos[i]'";
  $vecesPhoneResult= mysqli_query($conn, $queryVecesPhone);
  $rowPhones= mysqli_fetch_assoc($vecesPhoneResult);
  if ($rowPhones['veces']>1){
    echo "<script type='text/javascript'>alert('$array_telefonos[i]: $mensaje_telefono $queryVecesPhone $Veces')</script>";
  } else{
    echo "<script type='text/javascript'>alert('$array_telefonos[i]: $mensaje_telefono')</script>";
  }
  $vecesPhone= $rowPhones['veces'] + 1;
  $updatePhone= "UPDATE phones SET veces=$vecesPhone WHERE numero='$array_telefonos[i]'";
}
}
}
//SUSPECT QUERY
$CheckSuspect = "SELECT * FROM suspects WHERE cedula = '$cedula_sospechoso'";
// Variable $result mantiene los datos de conexion
$resultSuspect = $conn-> query($CheckSuspect);
// mantiene el resultado de la consulta, contando el numero de filas obtenidas
$countSuspect = mysqli_num_rows($resultSuspect);
// Si el resultado es 0 entonces el sospechoso no existe en la base de datos y se procede a registrar 
if ($countSuspect == 0) {
//registra los datos de la victima en la tabla victim
$QuerySuspect="INSERT INTO suspects (expedient, nombre, cedula, veces) VALUES ('$expediente', '$nombre_sospechoso', '$cedula_sospechoso', 1)";
if (mysqli_query($conn, $QuerySuspect)) {
echo "<h3>Se registraron correctamente los datos del sospechoso.</h3>";
} else {
    echo "Error en datos de sospechoso: " . $QuerySuspect . "<br>" . mysqli_error($conn);
}
    } else{
    //consulta la cantidad de veces que ha estafado ese numero de telefono
    $CheckVecesSuspect="SELECT veces FROM suspects where cedula = '$cedula_sospechoso' ";
    //guarda el resultado de la consulta
    $ResultSuspect = mysqli_query($conn,$CheckVecesSuspect);
    //valor de la fila
    $RowSuspect= mysqli_fetch_assoc($ResultSuspect);
    //contabiliza y muestra un mensaje acorde a la cantidad de veces que ha estafado antes ese telefono
    if ($RowSuspect['veces']>1) {
echo "<script type='text/javascript'>alert('El portador de la cédula: $cedula_sospechoso ha estafado antes $CheckVecesSuspect $Veces')</script>";
    } else{
echo "<script type='text/javascript'>alert('El portador de la cédula: $cedula_sospechoso ha estafado antes')</script>";
    }
    //suma una vez a las veces que ha sido estafado
    $vecesSuspect=$RowSuspect['veces'] + 1;
    //actualiza el campo $veces con un caso más
    $QuerySuspect= "UPDATE suspects SET veces='$vecesSuspect' WHERE cedula='$cedula_sospechoso'";
    echo "<h2>Actualizada la cantidad de veces que ha estafado el sospechoso, debido a que es reincidente</h2>";
    if (mysqli_query($conn, $QuerySuspect)) {
echo "<h3>Se registraron correctamente los datos del sospechoso.</h3>";
} else {
    echo "Error en datos de sospechoso: " . $QuerySuspect . "<br>" . mysqli_error($conn);
}
}
$QueryComplaint="INSERT INTO complaints (expedient, detail, monto) VALUES ('$expediente', '$descripcion_denuncia', '$monto')";
if (mysqli_query($conn, $QueryComplaint)) {
  echo "<h3>Se registraron correctamente los datos del expediente.</h3>";
  } else {
echo "Error en datos del expediente: " . $QueryComplaint . "<br>" . mysqli_error($conn);
  }
//header ("refresh:10;url=../denuncia.php");
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
<a href="../denuncia.php">Regresar a tomar una nueva denuncia</a>
</body>
</html>