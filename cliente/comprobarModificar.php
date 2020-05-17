<?php
//simplemente comprobamos que los datos son validos y los actualizamos en la base de datos, mandando un mensaje de exito
//si sale bien
include "../base_datos.php";
define("USUARIO", "CLIENTE");

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
            $art = $articulo->fetch(PDO::FETCH_ASSOC);
            //$art es un array con las variables del articulo

            if(count($art) <= 0){//NO HAY ARTICULOS
                $json['error'] = "El código de producto no es válido";
            }
            else{
                $consulta = "UPDATE lineas_pedidos SET COD_ARTICULO = :value WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :linea";
                $modificar = $conexion->prepare($consulta);
                $parametros = [":value"=> $value, ":cod"=> $cod, ":linea" => $linea];
                $modificar->execute($parametros);
                if($modificar->rowCount() > 0){
                    //ahora modificamos el precio en base al articulo
                    //primero seleccionamos la cantidad que ya existe en la linped
                    $consulta = "SELECT * FROM lineas_pedidos WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :linea";
                    $parametros = [":cod"=> $cod, ":linea" => $linea];
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute($parametros);
                    $datos = $resultado->fetch(PDO::FETCH_ASSOC);
                    //ahora $datos tiene informacion de la linea de pedidos
                    if(count($datos) <= 0){
                        $json['error'] = "Fallo al actualizar";
                    }
                    else{
                        $consulta = "UPDATE lineas_pedidos SET PRECIO = :precio WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :linea ";
                        $parametros = [":precio"=> $art['PRECIO'] * $datos['CANTIDAD'], ":cod"=> $cod, ":linea" => $linea];
                        $resultadofinal = $conexion->prepare($consulta);
                        $resultadofinal->execute($parametros);
                        if($resultadofinal->rowCount() > 0){
                            $json['success'] = "Artículo modificado con éxito.";
                        }
                        else{
                            $json['error'] = "Fallo al actualizar";
                        }
                    }
                }
                else{
                    $json['error'] = "Fallo al actualizar";
                }
            }

        }
        else if($header == "CANTIDAD"){
            $consulta = "UPDATE lineas_pedidos SET CANTIDAD = :value WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :linea";
            $modificar = $conexion->prepare($consulta);
            $parametros = [":value"=> $value, ":cod"=> $cod, ":linea" => $linea];
            $modificar->execute($parametros);
            if($modificar->rowCount() > 0){
                //modificamos el precio
                //solo hemos cambiado la cantidad, asi que sacamos el precio unitario con un select
                $consulta = "SELECT * FROM lineas_pedidos WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :linea";
                $parametros = [":cod"=> $cod, ":linea" => $linea];
                $resultado = $conexion->prepare($consulta);
                $resultado->execute($parametros);
                $datos = $resultado->fetch(PDO::FETCH_ASSOC);
                if(count($datos) <=0){
                    $json['error'] = 'Fallo al actualizar';
                }
                else{
                    //ahora podemos acceder al precio y a la cantidad para sacar el precio definitivo
                    $consulta = "UPDATE lineas_pedidos SET PRECIO = :precio WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :linea";
                    $parametros = [":precio" => $datos['PRECIO'] * $datos['CANTIDAD'], ":cod"=> $cod, ":linea" => $linea];
                    $resultadofinal = $conexion->prepare($consulta);
                    $resultadofinal->execute($parametros);
                    if($resultadofinal->rowCount() > 0){
                        $json['success'] = "Cantidad modificada con éxito.";
                    }
                    else{
                        $json['error'] = "Fallo al actualizar";
                    }
                }
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