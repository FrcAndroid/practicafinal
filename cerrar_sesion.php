<?php
//cerramos sesion y redirigimos a la pagina de inicio de sesion
include 'control_sesion.php';

if(isset($user)){
    $_SESSION = array();
    session_destroy();
    header("location:pagina_inicio.php");
}
