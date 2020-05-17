<?php
//simplemente comprobamos que los datos son validos y los actualizamos en la base de datos, mandando un mensaje de exito
//si sale bien
include "../base_datos.php";
include "control_sesion_gestor.php";
define("USUARIO", "GESTOR");

if(isset($_POST['value']) || isset($_POST['valueAlbaran']) || isset($_POST['valueFactura'])){
    $json = [];
    $header = $_POST['header'];//campo al que pertenece el valor modificado
    $cod = $_POST['cod'];
    isset($_POST['linea'])?$linea = $_POST['linea']:$linea = "";
    if(isset($_POST['value'])){
        $value = $_POST['value'];//valor modificado
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

                if(empty($art)){//NO HAY ARTICULOS
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
                            $json['error'] = "Fallo al actualizar 3";
                        }
                        else{
                            //el unico cambio es que insertamos el codigo del usuario de gestion
                            $consulta = "UPDATE lineas_pedidos SET PRECIO = :precio, COD_USUARIO_GESTION = :gestor WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :linea ";
                            $parametros = [":precio"=> $art['PRECIO'] * $datos['CANTIDAD'], ":cod"=> $cod, ":linea" => $linea, ":gestor" => $_SESSION['gestor']['COD_USUARIO_GESTION']];
                            $resultadofinal = $conexion->prepare($consulta);
                            $resultadofinal->execute($parametros);
                            if($resultadofinal->rowCount() > 0){
                                $json['success'] = "Artículo modificado con éxito.";
                            }
                            else{
                                $json['error'] = "Fallo al actualizar 2";
                            }
                        }
                    }
                    else{
                        $json['error'] = "Fallo al actualizar 1";
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
                        $json['error'] = 'Fallo al actualizar 4';
                    }
                    else{
                        //ahora podemos acceder al precio y a la cantidad para sacar el precio definitivo
                        //el unico cambio es que insertamos el codigo del usuario de gestion
                        $consulta = "UPDATE lineas_pedidos SET PRECIO = :precio, COD_USUARIO_GESTION = :gestor WHERE COD_PEDIDO = :cod AND NUM_LINEA_PEDIDO = :linea";
                        $parametros = [":precio" => $datos['PRECIO'] * $datos['CANTIDAD'], ":cod"=> $cod, ":linea" => $linea, ":gestor" => $_SESSION['gestor']['COD_USUARIO_GESTION']];
                        $resultadofinal = $conexion->prepare($consulta);
                        $resultadofinal->execute($parametros);
                        if($resultadofinal->rowCount() > 0){
                            $json['success'] = "Cantidad modificada con éxito.";
                        }
                        else{
                            $json['error'] = "Fallo al actualizar 5";
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
    }
    if(isset($_POST['valueAlbaran'])){
        $value = $_POST['valueAlbaran'];//valor modificado
        //solo comprobamos que el value no tenga nada raro
        if(is_numeric($value) && $value>0){
            $conexion = conectar(USUARIO);
            //tenemos 3 headers, descuento, precio, iva
            //solo comprobamos que los valores introducidos son numéricos y positivos, y que los headers son correctos
            if($header == "PRECIO") {
                $consulta = "UPDATE lineas_albaran SET PRECIO = :precio, COD_USUARIO_GESTION = :gestor WHERE COD_ALBARAN = :cod AND NUM_LINEA_ALBARAN = :linea";
                $parametros = [":precio" => $value, ":cod" => $cod, ":linea" => $linea, ":gestor" => $_SESSION['gestor']['COD_USUARIO_GESTION']];
                $resultadofinal = $conexion->prepare($consulta);
                $resultadofinal->execute($parametros);
                if ($resultadofinal->rowCount() > 0) {
                    $json['success'] = "Precio modificado con éxito.";
                } else {
                    $json['error'] = "Fallo al actualizar";
                }
            }
            elseif($header == "DESCUENTO"){
                $consulta = "UPDATE lineas_albaran SET DESCUENTO = :descuento, COD_USUARIO_GESTION = :gestor WHERE COD_ALBARAN = :cod AND NUM_LINEA_ALBARAN = :linea";
                $parametros = [":descuento" => $value, ":cod" => $cod, ":linea" => $linea, ":gestor" => $_SESSION['gestor']['COD_USUARIO_GESTION']];
                $resultadofinal = $conexion->prepare($consulta);
                $resultadofinal->execute($parametros);
                if ($resultadofinal->rowCount() > 0) {
                    $json['success'] = "Descuento modificado con éxito.";
                } else {
                    $json['error'] = "Fallo al actualizar";
                }
            }
            elseif($header == "IVA"){
                $consulta = "UPDATE lineas_albaran SET IVA = :iva, COD_USUARIO_GESTION = :gestor WHERE COD_ALBARAN = :cod AND NUM_LINEA_ALBARAN = :linea";
                $parametros = [":iva    " => $value, ":cod" => $cod, ":linea" => $linea, ":gestor" => $_SESSION['gestor']['COD_USUARIO_GESTION']];
                $resultadofinal = $conexion->prepare($consulta);
                $resultadofinal->execute($parametros);
                if ($resultadofinal->rowCount() > 0) {
                    $json['success'] = "IVA modificado con éxito.";
                } else {
                    $json['error'] = "Fallo al actualizar";
                }
            }
            else{
                $json['error'] = "Header no permitido";
            }
        }
        else{
            $json['error'] = "Valor no válido";
        }
    }

    if(isset($_POST['valueFactura'])){
        $value = $_POST['valueFactura'];
        if(is_numeric($value) && $value>0){
            if($header == "DESCUENTO_FACTURA"){
                $conexion = conectar(USUARIO);
                $consulta = "UPDATE facturas SET DESCUENTO_FACTURA = :descuento WHERE COD_FACTURA = :cod";
                $parametros = [":descuento" => $value, ":cod" => $cod];
                $resultado = $conexion->prepare($consulta);
                $resultado->execute($parametros);
                if($resultado->rowCount()>0){
                    $json['success'] = "Descuento actualizado con éxito";
                }
                else{
                    $json['error'] = "Fallo al actualizar el descuento";
                }
            }
            else{
                $json['error'] = "Header no válido";
            }
        }
        else{
            $json['error'] = "Valor no válido";
        }
    }





    echo json_encode($json);
}