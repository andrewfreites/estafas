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
    echo "se creó datos de la victima";
  } else{ //si no solo se actualiza el numero de veces que ha sido estafada
    //consulta la cantidad de veces que ha sido estafado
    $CheckVeces="SELECT veces FROM victim where cedula = '$_POST[cedula_sospechoso]' ";
    //mantiene los datos de la conexion
    $resultVeces = $conn-> query($CheckVeces);
    //suma una vez a las veces que ha sido estafado
    $veces=$CheckVeces + 1;
    //actualiza el campo $veces con un caso más
    $QueryVictim= "UPDATE victim SET veces='$veces' WHERE numero='$_POST[numero_sospechoso]'";
    echo "se actualizó datos de la victima";
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
        //revisar el numero de veces que ha sido registrada la cuenta
        $CheckCasos= "SELECT casos FROM accounts WHERE numero = '$_POST[numero_sospechoso]'";
        //Si es mayor a 1 muestra una alerta en plural, si no en singular
        if ($CheckCasos>1) {
            $mensaje="Esta cuenta ha estafado antes ";
            $veces=" veces";
            echo "<script type='text/javascript'>alert('$mensaje $CheckCasos $veces');</script>";
        } else{
            echo "<script type='text/javascript'>alert('$mensaje');</script>";
        }
        $casos=$CheckCasos + 1; //suma una denuncia al conteo de casos de la cuenta
        $QueryAccounts= "UPDATE accounts SET casos='$casos' WHERE numero='$_POST[numero_sospechoso]'";
        echo "se actualizó el numero de casos de la cuenta";
    } else{
        $QueryAccounts= "INSERT INTO accounts (banco, numero, casos, sospechoso) VALUES ('$banco_sospechoso', '$numero_sospechoso', 1,'$telefono_sospechoso')";
        echo "se creó un registro de cuenta";
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
    echo "se registró datos del sospechoso";
    } else{
    //consulta la cantidad de veces que ha estafado
    $CheckVecesSuspect="SELECT veces FROM victim where cedula = '$_POST[cedula_sospechoso]' ";
    //mantiene los datos de la conexion
    $resultVecesSuspect = $conn-> query($CheckVecesSuspect);
    //suma una vez a las veces que ha sido estafado
    $vecesSuspect=$CheckVecesSuspect + 1;
    //actualiza el campo $veces con un caso más
    $QuerySuspect= "UPDATE suspects SET veces='$vecesSuspect' WHERE telefono='$_POST[telefono_sospechoso]'";
    echo "se actualizó las veces del mismo sospechoso";
  }
  //Comprobación de las operaciones con la base de datos
    if (mysqli_query($conn, $QueryVictim)) {
    echo "<h3>Se registraron correctamente los datos de la victima.</h3>";
    } else {
        echo "Error: " . $QueryVictim . "<br>" . mysqli_error($conn);
    }
    if (mysqli_query($conn, $QueryAccounts)) {
        echo "<h3>Se registraron correctamente los datos de la cuenta.</h3>";
        } else {
            echo "Error: " . $QueryAccounts . "<br>" . mysqli_error($conn);
        }
    if (mysqli_query($conn, $QuerySuspect)) {
        echo "<h3>Se registraron correctamente los datos del sospechoso.</h3>";
        } else {
            echo "Error: " . $QuerySuspect . "<br>" . mysqli_error($conn);
        }
  header ("refresh:10;url=../denuncia.php");
  echo "se redireccionará en 10 segundos";
    //cerrar conexión
    mysqli_close($conn);
?>