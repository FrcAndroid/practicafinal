<?php
//simplemente comprobamos que los datos son validos y los actualizamos en la base de datos, mandando un mensaje de exito
//si sale bien
include "base_datos.php";
define("USUARIO", "CLIENTES");

if(isset($_POST['value'])){
    $json = [];
    $value = $_POST['value'];//valor modificado
    $header = $_POST['header'];//campo al que pertenece el valor modificado
    $cod = $_POST['cod'];
    $linea = $_POST['linea'];

    //solo comprobamos que el value no tenga nada raro
    if(is_numeric($value)){
        $conexion = conectar(USUARIO);
        if($header == "COD_ARTICULO"){
            //aqui comprobamos primero que el producto al que vamos a actualizar es un producto real
            $consulta = "SELECT * FROM articulos WHERE COD_ARTICULO = :value";
            $articulo = $conexion->prepare($consulta);
            $parametros = [":value" => $value];
            $articulo->execute($parametros);
            if(count($articulo->fetchAll(PDO::FETCH_ASSOC)) <= 0){//NO HAY ARTICULOS
                $json['error'] = "El código de producto no es válido";
            }
            else{
                $consulta = "UPDATE lineas_pedidos SET COD_ARTICULO = :value WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :linea";
                $modificar = $conexion->prepare($consulta);
                $parametros = [":value"=> $value, ":cod"=> $cod, ":linea" => $linea];
                $modificar->execute($parametros);
                if($modificar->rowCount() > 0){
                    $json['exito'] = "Artículo modificado con éxito.";
                }
            }

        }
        else if($header == "CANTIDAD"){
            $consulta = "UPDATE lineas_pedidos SET CANTIDAD = :value WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :linea";
            $modificar = $conexion->prepare($consulta);
            $parametros = [":value"=> $value, ":cod"=> $cod, ":linea" => $linea];
            $modificar->execute($parametros);
            if($modificar->rowCount() > 0){
                $json['exito'] = "Cantidad modificada con éxito.";
            }
        }
        else{
            $json['error'] = "Header no permitido";
        }
    }
    else{
        $json['error'] = "Valor no válido";
    }

    echo json_encode($json);
}