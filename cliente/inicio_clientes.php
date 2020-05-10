<?php

include 'control_sesion_cliente.php';
include '../portada.php';
if(isset($_SESSION['cliente'])){
    include 'barracliente.php';
}

?>

