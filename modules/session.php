<?php
//un muy mal intento de cerrar sesion por inactividad, luego vere como lo hago
if(isset($_SESSION['start'])){
    $inactivo=60;
    $duracion= time()-$_SESSION['start'];
    if($duracion>$inactivo){
        session_unset();
        session_destroy;
        header ("refresh:10;url= index.html");
    }
} else{
    $_SESSION['start']=time();
}
?>