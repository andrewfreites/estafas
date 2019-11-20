<?php
//Inicia una nueva sesión o reanuda la existente 
    session_start(); 
//Remueve las variables de la sesión
    session_unset();
//Destruye toda la información registrada de una sesión
    session_destroy(); 
//Redirecciona a la página de login
    header('location: ../index.html'); 
?>