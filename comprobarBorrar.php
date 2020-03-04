<?php
include "base_datos.php";
define("USUARIO", "root");
//todas las comprobaciones se hacen antes de haber entrado aquí, así que solo hacemos el delete
if(isset($_POST['borrar'])){//venimos a borrar
    $json = [];
    $cod = $_POST['cod'];
    $linea = $_POST['linea'];

    $conexion = conectar(USUARIO);
    $consulta = "DELETE FROM lineas_pedidos WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :linea";
    $parametros = [":cod" => $cod, ":linea" => $linea];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    if($resultado->execute() > 0){//se han borrado
        $json['exito'] = "Linea borrada con éxito";
    }
    else{
        $json['error'] = "Fallo al borrar la línea";
    }
    echo json_encode($json);
}

if(isset($_POST['eliminar'])){//venimos a eliminar el pedido
    $json = [];
    $cod = $_POST['cod'];
    $conexion = conectar(USUARIO);

    //primero nos aseguramos de que no queden lineas de pedido sin borrar
    $consulta = "DELETE FROM lineas_pedidos WHERE COD_PEDIDO = :cod";
    $parametros = [":cod" => $cod];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    if($resultado->execute() > 0){//se ha borrado
        $consulta = "DELETE FROM pedidos WHERE COD_PEDIDO = :cod";
        $parametros = [":cod" => $cod];
        $resultado = $conexion->prepare($consulta);
        $resultado->execute($parametros);
        if($resultado->execute() > 0){//se ha borrado
            $json['exito'] = "Pedido borrado con éxito";
        }
        else{
            $json['error'] = "Fallo al borrar el pedido";
        }
    }
    else{
        $json['error'] = "Fallo al borrar las lineas del pedido";
    }


    echo json_encode($json);
}