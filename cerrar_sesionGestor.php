<?php
//cerramos sesion y redirigimos a la pagina de inicio de gestion
include 'base_datos.php';
include 'control_sesion.php';
define("USUARIO", "GESTOR");

if(isset($user)){
    $conexion = conectar(USUARIO);
    $consulta = "UPDATE accesos SET FECHA_HORA_SALIDA = :fecha WHERE FECHA_HORA_SALIDA == NULL AND COD_USUARIO = :cod";
    $parametros = [":fecha" => date("Y-m-d H:i:s"), ":cod" => $user['NICK']];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    if($resultado->rowCount() > 0){
        $_SESSION = array();
        session_destroy();
        header("location:inicio_gestor.php");
    }
}
