<?php
include "../base_datos.php";
define("USUARIO", "GESTOR");
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
        //ahora comprobamos si es la última linea del pedido, y si ya no quedan lineas, borramos el pedido al completo
        $consulta = "SELECT * FROM lineas_pedidos WHERE COD_PEDIDO = :cod ";
        $parametros = [":cod" => $cod];
        $resultado = $conexion->prepare($consulta);
        $resultado->execute($parametros);
        if(count($resultado->fetchAll(PDO::FETCH_ASSOC)) < 1){
            //borramos el pedido al completo
            $consulta = "DELETE FROM pedidos WHERE COD_PEDIDO = :cod";
            $parametros = [":cod" => $cod];
            $resultado = $conexion->prepare($consulta);
            $resultado->execute($parametros);
            if($resultado->rowCount() > 0){
                $json['borrado'] = true;
                $json['exito'] = "Pedido borrado con éxito";
            }
            else{
                $json['error'] = "Fallo al borrar el pedido";
            }
        }
        else{
            $json['exito'] = "Linea borrada con éxito";
        }
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

if(isset($_POST['pedido'])){
    $lineaPedido = $_POST['pedido'];
    $codPedido = $_POST['cod'];

    $conexion = conectar(USUARIO);
    $consulta = "DELETE FROM lineas_pedido WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :num";
    $parametros = [":cod" => $codPedido, ":num" => $lineaPedido];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    if($resultado->rowCount() > 0){
        $json['success'] = "Linea dada de baja de pedido.";
    }
    else{
        $json['error'] = "Fallo al dar de baja de pedido";
    }

    echo json_encode($json);

}

if(isset($_POST['eliminarAlbaran'])){//venimos a eliminar el albaran
    $json = [];
    $cod = $_POST['cod'];
    $conexion = conectar(USUARIO);

    //primero nos aseguramos de que no queden lineas de pedido sin borrar
    $consulta = "DELETE FROM lineas_albaran WHERE COD_ALBARAN = :cod";
    $parametros = [":cod" => $cod];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    if($resultado->execute() > 0){//se ha borrado
        $consulta = "DELETE FROM albaranes WHERE COD_ALBARAN = :cod";
        $parametros = [":cod" => $cod];
        $resultado = $conexion->prepare($consulta);
        $resultado->execute($parametros);
        if($resultado->execute() > 0){//se ha borrado
            $json['exito'] = "Albarán borrado con éxito";
        }
        else{
            $json['error'] = "Fallo al borrar el albarán";
        }
    }
    else{
        $json['error'] = "Fallo al borrar las lineas del albarán";
    }


    echo json_encode($json);
}


if(isset($_POST['borrarAlbaran'])){//venimos a borrar
    $json = [];
    $cod = $_POST['cod'];
    $linea = $_POST['linea'];

    $conexion = conectar(USUARIO);
    $consulta = "DELETE FROM lineas_albaran WHERE COD_ALBARAN = :cod AND NUM_LINEA_ALBARAN = :linea";
    $parametros = [":cod" => $cod, ":linea" => $linea];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    if($resultado->execute() > 0){//se han borrado
        //ahora comprobamos si es la última linea del albaran, y si ya no quedan lineas, borramos el albaran al completo
        $consulta = "SELECT * FROM lineas_albaran WHERE COD_ALBARAN = :cod ";
        $parametros = [":cod" => $cod];
        $resultado = $conexion->prepare($consulta);
        $resultado->execute($parametros);
        if(count($resultado->fetchAll(PDO::FETCH_ASSOC)) < 1){
            //borramos el albaran al completo
            $consulta = "DELETE FROM albaranes WHERE COD_ALBARAN = :cod";
            $parametros = [":cod" => $cod];
            $resultado = $conexion->prepare($consulta);
            $resultado->execute($parametros);
            if($resultado->rowCount() > 0){
                $json['borrado'] = true;
                $json['exito'] = "Albarán borrado con éxito";
            }
            else{
                $json['error'] = "Fallo al borrar el albarán";
            }
        }
        else{
            $json['exito'] = "Linea borrada con éxito";
        }
    }
    else{
        $json['error'] = "Fallo al borrar la línea";
    }
    echo json_encode($json);
}

if(isset($_POST['eliminarFactura'])){
    $json = [];
    $cod = $_POST['cod'];
    $conexion = conectar(USUARIO);

    //primero nos aseguramos de que no queden lineas de pedido sin borrar
    $consulta = "DELETE FROM lineas_facturas WHERE COD_FACTURA = :cod";
    $parametros = [":cod" => $cod];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    if($resultado->execute() > 0){//se ha borrado
        $consulta = "DELETE FROM facturas WHERE COD_FACTURA = :cod";
        $parametros = [":cod" => $cod];
        $resultado = $conexion->prepare($consulta);
        $resultado->execute($parametros);
        if($resultado->execute() > 0){//se ha borrado
            $json['exito'] = "Factura borrada con éxito";
        }
        else{
            $json['error'] = "Fallo al borrar la factura";
        }
    }
    else{
        $json['error'] = "Fallo al borrar las lineas de la factura";
    }


    echo json_encode($json);
}

if(isset($_POST['desfacturar'])){
    //borramos linea individual de factura
    $conexion = conectar(USUARIO);
    $codFactura = $_POST['cod'];
    $lineaFactura = $_POST['linea'];
    $consulta = "DELETE FROM lineas_facturas WHERE COD_FACTURA = :cod AND NUM_LINEA_FACTURA = :linea";
    $parametros = [":cod" => $codFactura, ":linea" => $lineaFactura];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    if($resultado->execute() > 0){//se han borrado
        //ahora comprobamos si es la última linea del albaran, y si ya no quedan lineas, borramos la factura al completo
        $consulta = "SELECT * FROM lineas_facturas WHERE COD_FACTURA = :cod ";
        $parametros = [":cod" => $codFactura];
        $resultado = $conexion->prepare($consulta);
        $resultado->execute($parametros);
        if(count($resultado->fetchAll(PDO::FETCH_ASSOC)) < 1){
            //borramos la factura al completo
            $consulta = "DELETE FROM facturas WHERE COD_FACTURA = :cod";
            $parametros = [":cod" => $codFactura];
            $resultado = $conexion->prepare($consulta);
            $resultado->execute($parametros);
            if($resultado->rowCount() > 0){
                $json['borrado'] = true;
                $json['success'] = "Factura borrada con éxito";
            }
            else{
                $json['error'] = "Fallo al borrar la factura";
            }
        }
        else{
            $json['success'] = "Albaran desfacturado con éxito";
        }
    }
    else{
        $json['error'] = "Fallo al borrar el albarán";
    }

    echo json_encode($json);
}