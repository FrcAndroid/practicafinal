<?php
include "base_datos.php";
define("USUARIO", "root");
//recibimos los datos del ajax
if(isset($_POST['valores'])){
    $form = explode("&", $_POST['valores']);//post serializado
    //esto nos da [0] = key=value asi que hacemos otro explode por cada iteracion del form
    $valores = []; //array asociativo con key/value

    for($i=0; $i< count($form); $i++){
        $key_value = explode("=",$form[$i]);
        //nos da dos valores, 0 es la key, 1 el value
        $valores[$key_value[0]] = $key_value[1];
    }

    //tenemos un array con los valores, seleccionamos el producto usando el codArt

    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM articulos WHERE COD_ARTICULO = :codart";
    $resultado = $conexion->prepare($consulta);
    $parametros = [":codart" => $valores['codArt']];
    $resultado->execute($parametros);

    if($resultado){
        $articulo = $resultado->fetch(PDO::FETCH_ASSOC);
        echo json_encode($articulo);//devuelve articulo a ajax
    }
}