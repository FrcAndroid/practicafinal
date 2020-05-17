<?php
include "../base_datos.php";
include "control_sesion_gestor.php";
define('USUARIO', 'GESTOR');
if(isset($_POST['cliente'])){
    //el proposito de este codigo es sacar la lista de albaranes de un cliente específico
    $cliente = $_POST['cliente'];
    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM albaranes WHERE COD_CLIENTE = :cliente";
    $parametros = [":cliente" => $cliente];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    $lista = $resultado->fetchAll(PDO::FETCH_ASSOC);
    if(count($lista)>0){
        //hay albaranes y los devolvemos
        $json['lista'] = $lista;
    }
    else{
        $json['error'] = "No hay albaranes en este cliente.";
    }
    echo json_encode($json);
}

if(isset($_POST['albaran'])){
    //venimos a procesar el/los albaranes en una unica factura
    if(isset($_POST['descuento'])){
        $descuento = $_POST['descuento'];
        if(is_numeric($descuento) && $descuento>=0){
            //es un array que contiene los codigos de albaranes los cuales convertiremos en lineas de factura
            //primero seleccionamos todos los albaranes a partir de sus codigos y los guardamos en un array
            $albaranes = $_POST['albaran'];
            $listaAlbaranes = [];
            $conexion = conectar(USUARIO);
            foreach($albaranes as $albaran){
                //recorremos el array para seleccionar uno a uno las lineas de albaranes
                $consulta = "SELECT * FROM lineas_albaran WHERE COD_ALBARAN = :cod";
                $parametros = [":cod" => $albaran];
                $resultado = $conexion->prepare($consulta);
                $resultado->execute($parametros);
                $listaAlbaranes[] = $resultado->fetchAll(PDO::FETCH_ASSOC);//recoge todos los albaranes en un indice
            }
            //tenemos un array con los albaranes y los introducimos como lineas de factura, pero primero creamos la factura
            $consulta = "INSERT INTO facturas (COD_CLIENTE, FECHA, DESCUENTO_FACTURA, CONCEPTO)
                    VALUES (:cod, :fec, :desc, :con)";
            $parametros = [":cod" => $_POST['codcliente'], ":fec" =>  date("Y-m-d H:i:s"), ":desc" => $descuento, ":con" => $_POST['concepto']];
            $resultado = $conexion->prepare($consulta);
            $resultado->execute($parametros);
            if($resultado->rowCount()>0){
                //seleccionamos el CODIGO de la factura (autoincrement) y lo usamos para poner el codigo de la linea de factura
                $consulta = "SELECT MAX(COD_FACTURA) as ID_MAX FROM facturas";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $id = $resultado->fetch(PDO::FETCH_ASSOC);

                //Tenemos todos los datos y estamos listos para hacer el procesado final, usamos un array para introducir una linea por cada albaran
                $i=0;
                foreach($listaAlbaranes as $albaranes) {
                    //en cada indice estan las lineas de albaran, los cuales recorremos con OTRO foreach
                    foreach ($albaranes as $albaran) {
                        //y ahora si, introducimos las lineas una a una en lineas_facturas
                        $consulta1 = "INSERT INTO lineas_facturas 
                                        (
                                        NUM_LINEA_FACTURA,
                                        COD_ALBARAN,
                                        COD_CLIENTE,
                                        COD_FACTURA,
                                        NUM_LINEA_ALBARAN,
                                        COD_ARTICULO,
                                        PRECIO,
                                        CANTIDAD,
                                        DESCUENTO,
                                        IVA,
                                        COD_USUARIO_GESTION
                                        )
                                        VALUES(
                                        :numfac,
                                        :codalb,
                                        :codcli,
                                        :codfac,
                                        :numalb,
                                        :codart,
                                        :prec,
                                        :cant,
                                        :descuento,
                                        :iva,
                                        :codusu
                                        )";
                    }

                    $parametros = [
                        ":numfac" => $i,
                        ":codalb" => $albaran['COD_ALBARAN'],
                        ":codcli" => $albaran['COD_CLIENTE'],
                        ":codfac" => $id['ID_MAX'],
                        ":numalb" => $albaran['NUM_LINEA_ALBARAN'],
                        ":codart" => $albaran["COD_ARTICULO"],
                        ":prec" => $albaran['PRECIO'],
                        ":cant" => $albaran['CANTIDAD'],
                        ":descuento" => $albaran["DESCUENTO"],
                        ":iva" => $albaran["IVA"],
                        ":codusu" => $_SESSION['gestor']['COD_USUARIO_GESTION']
                    ];
                    $resultado = $conexion->prepare($consulta1);
                    $resultado->execute($parametros);
                    if($resultado->rowCount() > 0){
                        //teoricamente, al haber introducido estos datos en la linea del albaran, el resto de restricciones se activan
                    }
                    else{
                        $json['error'] = "Fallo al crear linea $i";
                    }
                    $i++;
                }
            }
            else {
                $json['error'] = "Fallo al crear factura";
            }
        }
        else{
            $json['error'] = "Descuento no válido";
        }
    }


    if(empty($json['error'])){
        $json['success'] = "Albarán procesado exitosamente";
    }

    echo json_encode($json);
}