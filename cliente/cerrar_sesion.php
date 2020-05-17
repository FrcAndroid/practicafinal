<?php
//cerramos sesion y redirigimos a la pagina de inicio de sesion
include 'control_sesion_cliente.php';
if(isset($_SESSION['cliente'])){
    $_SESSION = array();
    session_destroy();
    header("location:../pagina_inicio.php");
}
