<?php
include "base_datos.php";
include "control_sesion.php";
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

if(isset($_POST['generar'])){
    //recibimos el array de pedidos y lo generamos con transaccion atomica
    $pedido = $_POST['pedido'];
    var_dump($pedido);
    //primero introducimos el pedido nuevo
    $conexion = conectar(USUARIO);
    $consulta = "INSERT INTO pedidos (FECHA, GENERADO_POR_CLIENTE) VALUES (:fecha, :cliente)";
    $fecha = date('d/m/Y h:i:s a');
    $cliente = $user['COD_CLIENTE'];
    $resultado = $conexion->prepare($consulta);
    $parametros = [":fecha"=> $fecha, ":cliente"=> $cliente];
    $resultado->execute($parametros);
    if($resultado->rowCount() > 0){
        //primero sacamos el codigo del pedido
        $consulta = "SELECT MAX(COD_PEDIDO) FROM pedidos";//devuelve el ultimo codigo de pedido, que es el que estamos generando
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        if($resultado){
            $cod_pedido = $resultado->fetch(PDO::FETCH_ASSOC);
            //variables necesarias
            //num_linea (va de 0 a cuando termine el pedido)
            //precio, cantidad, articulo
            //cod_usuario (sesion)
            //cod_pedido
            // //ahora hacemos la transaccion
            //recorremos el array pedido


        }

    }
}