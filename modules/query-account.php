<?php
session_start();
header("Cache-control:private"); 
if($_SESSION['loggedin']=="") 
{ 
 header("Location:../index.html"); 
 exit; 
}

include 'conexion.php';
$consulta= "SELECT * FROM accounts WHERE numero='$_POST[cuenta_sospechoso]'";
?>