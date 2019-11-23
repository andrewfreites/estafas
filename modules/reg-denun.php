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
$cedula_sospechoso=$_POST['cedula_sospechoso'];
$banco_sospechoso=$_POST['banco_sospechoso'];
$numero_sospechoso=$_POST['numero_sospechoso'];
$telefono_sospechoso=$_POST['telefono_sospechoso'];
$nombre_sospechoso=$_POST['nombre_sospechoso'];
$email_sospechoso=$_POST['email_sospechoso'];
$cedula_victima=$_POST['cedula_victima'];
$nombre_victima=$_POST['nombre_victima'];
$banco_victima=$_POST['banco_victima'];
$numero_victima=$_POST['numero_victima'];
$telefono_victima=$_POST['telefono_victima'];
$email_victima=$_POST['email_victima'];
$fecha=$_POST['fecha'];
$descripcion_denuncia=$_POST['descripcion_denuncia'];
$mensaje_victima="Esta persona ha sido estafada antes ";
$mensaje_cuenta="Esta cuenta ha estafado antes ";
$mensaje_telefono="Este numero de teléfono ha estafado antes ";
$Veces=" veces";


//Registro de una tabla de denuncias
$QueryComplaint="INSERT INTO complaints (victima,banco,cuenta,telefono,descripcion,fecha) VALUES ('$cedula_victima','$banco_sospechoso','$numero_sospechoso','$telefono_sospechoso','$descripcion_denuncia','$fecha')";

//REGISTRO DE DATOS DE VICTIMA

  // consulta que revisa si la victima existe en la base de datos
  $CheckVictim = "SELECT * FROM victim WHERE cedula = '$_POST[cedula_sospechoso]' ";

  // Variable $result mantiene los datos de conexion
  $resultVictim = $conn-> query($CheckVictim);

  // mantiene el resultado de la consulta, contando el numero de filas obtenidas
  $countVictim = mysqli_num_rows($resultVictim);

  // Si el resultado es 0 entonces la victima no existe en la base de datos y se procede a registrar 
  if ($countVictim == 0) {
    //registra los datos de la victima en la tabla victim
    $QueryVictim="INSERT INTO victim (nombre, cedula, telefono, email, veces) VALUES ('$nombre_victima', '$cedula_victima', '$telefono_victima', '$email_victima', 1)";
    echo "<p>Se registró una nueva victima</p>";
  } else{ //si no solo se actualiza el numero de veces que ha sido estafada
    //consulta la cantidad de veces que ha sido estafado
    $CheckVeces="SELECT veces FROM victim where cedula = '$_POST[cedula_sospechoso]' ";
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
  }

//REGISTRO DE LA CUENTA DEL SOSPECHOSO
  // consulta que revisa si la cuenta existe comparando el numero introducido con los existentes en la base de datos
	$CheckAccount = "SELECT * FROM accounts WHERE numero = '$_POST[numero_sospechoso]' ";

	// Variable $result mantiene los datos de conexion
	$result = $conn-> query($CheckAccount);

	// mantiene el resultado de la consulta, contando el numero de filas obtenidas
	$count = mysqli_num_rows($result);

    // Si el resultado es 1 entonces la cuenta existe, 
    if ($count == 1) {
        //guarda la consulta de los casos en la tabla cuentas
        $CheckCasos= "SELECT casos FROM accounts WHERE numero = '$_POST[numero_sospechoso]'";
        //guarda el resultado de la consulta
        $ResultAccounts = mysqli_query($conn,$CheckCasos);
        //Guarda el valor de la consulta
        $RowAccount= mysqli_fetch_assoc($ResultAccounts);
        //variable que guarda el valor de la columna 'casos' de la tabla 'accounts'
        $TimesAccount=$RowAccount['casos'];
        //Si es mayor a 1 muestra una alerta en plural, si no en singular
        if ($RowAccount['casos']>1) {
          echo "<script type='text/javascript'>alert('$mensaje_cuenta $TimesAccount $Veces')</script>";
        } else{
          echo "<script type='text/javascript'>alert('$mensaje_cuenta')</script>";
        }
        $casos=$RowAccount['casos'] + 1; //suma una denuncia al conteo de casos de la cuenta
        $QueryAccounts= "UPDATE accounts SET casos='$casos' WHERE numero='$_POST[numero_sospechoso]'";
        echo "<p>Se actualizó el numero de casos de estafa asociados a la cuenta</p>";
    } else{
        $QueryAccounts= "INSERT INTO accounts (banco, numero, casos, sospechoso) VALUES ('$banco_sospechoso', '$numero_sospechoso', 1,'$telefono_sospechoso')";
        echo "<p>Se registro una nueva cuenta bancaria estafadora en la base datos</p>";
    }

//registro de datos del sospechoso
    // consulta que revisa si el sospechoso existe en la base de datos, tomando el numero de telefono que es el dato mas comun de conocer
    $CheckSuspect = "SELECT * FROM suspects WHERE telefono = '$_POST[telefono_sospechoso]' ";
    // Variable $result mantiene los datos de conexion
    $resultSuspect = $conn-> query($CheckSuspect);
    // mantiene el resultado de la consulta, contando el numero de filas obtenidas
    $countSuspect = mysqli_num_rows($resultSuspect);
    // Si el resultado es 0 entonces el sospechoso no existe en la base de datos y se procede a registrar 
    if ($countSuspect == 0) {
    //registra los datos de la victima en la tabla victim
    $QuerySuspect="INSERT INTO suspects (nombre, cedula, telefono, email, veces) VALUES ('$nombre_sospechoso', '$cedula_sospechoso', '$telefono_sospechoso', '$email_sospechoso', 1)";
    echo "<p>Se registró datos del nuevo sospechoso</p>";
    } else{
    //consulta la cantidad de veces que ha estafado ese numero de telefono
    $CheckVecesSuspect="SELECT veces FROM suspects where telefono = '$telefono_sospechoso' ";
    //guarda el resultado de la consulta
    $ResultSuspect = mysqli_query($conn,$CheckVecesSuspect);
    //valor de la fila
    $RowSuspect= mysqli_fetch_assoc($ResultSuspect);
    //contabiliza y muestra un mensaje acorde a la cantidad de veces que ha estafado antes ese telefono
    if ($RowSuspect['veces']>1) {
      echo "<script type='text/javascript'>alert('$mensaje_telefono $CheckVecesSuspect $Veces')</script>";
    } else{
      echo "<script type='text/javascript'>alert('$mensaje_telefono')</script>";
    }
    //suma una vez a las veces que ha sido estafado
    $vecesSuspect=$RowSuspect['veces'] + 1;
    //actualiza el campo $veces con un caso más
    $QuerySuspect= "UPDATE suspects SET veces='$vecesSuspect' WHERE telefono='$_POST[telefono_sospechoso]'";
    echo "<p>Actualizada la cantidad de veces que ha estafado el sospechoso, debido a que es reincidente</p>";
  }
  //Comprobación de las operaciones con la base de datos
    if (mysqli_query($conn, $QueryVictim)) {
    echo "<h3>Se registraron correctamente los datos de la victima.</h3>";
    } else {
        echo "Error en datos de la victima: " . $QueryVictim . "<br>" . mysqli_error($conn);
    }
    if (mysqli_query($conn, $QueryAccounts)) {
        echo "<h3>Se registraron correctamente los datos de la cuenta.</h3>";
        } else {
            echo "Error en datos de cuenta: " . $QueryAccounts . "<br>" . mysqli_error($conn);
        }
    if (mysqli_query($conn, $QuerySuspect)) {
        echo "<h3>Se registraron correctamente los datos del sospechoso.</h3>";
        } else {
            echo "Error en datos de sospechoso: " . $QuerySuspect . "<br>" . mysqli_error($conn);
        }
    if (mysqli_query($conn, $QueryComplaint)) {
      echo "<h3>Se registraron correctamente los datos de la denuncia.</h3>";
      } else {
          echo "Error en datos de la denuncia: " . $QueryComplaint . "<br>" . mysqli_error($conn);
      }
  header ("refresh:10;url=../denuncia.php");
  echo "<p>En 10 segundos será regresado al sistema de registro de denuncias</p>";
  //cerrar conexión
  mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
  <title>Procesando registro de denuncia</title>
</head>
<body>
  
</body>
</html>