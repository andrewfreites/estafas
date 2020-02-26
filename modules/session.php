<?php
if(isset($_SESSION['active'])){

    echo "start esta fijado ";
    $inactivo=1*60;
    $duracion= time()-$_SESSION['active'];
    echo "start: ". $_SESSION['start'];
    echo "duracion: $duracion ";
    if($duracion>$inactivo){
        session_unset();
        session_destroy();
        echo "la sesión ha caducado";
        header ('location: modules/logout.php');
    }
} else{
    echo "start no esta fijado";
    $_SESSION['active']=time();
}
?>