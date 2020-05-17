<?php
include "../base_datos.php";
include "control_sesion_gestor.php";

//recibimos los valores de ajax
$codPedido = $_POST['pedido'];
$lineasProcesar = $_POST['lineas'];

//datos que tenemos que meter en lineas de albaran
/*
 * NUM_LINEA_ALBARAN -> linea
 * COD_CLIENTE -> Leido desde cod pedido
 * COD_ALBARAN -> Auto increment
 * PRECIO -> Se lee en lineas_pedidos y accedes mediante NUM_LINEA = LINEA A PROCESAR + COD_PEDIDO
 * CANTIDAD-> Ídem
 * DESCUENTO->Se lee desde el articulo que se encuentra en la linea de pedido (un join bien guapo)
 * IVA->Idem
 * NUM_LINEA_PEDIDO -> Se lee en lineas_pedidos
 * COD_PEDIDO -> Lo hemos recibido
 * COD_ARTICULO -> Lo leemos de lineas_pedidos
 * COD_USUARIO_GESTION -> el gestor
 */
define('USUARIO', 'GESTOR');
$conexion = conectar(USUARIO);
//primero vamos a seleccionar los datos para los cuales dependemos de otras tablas
//deberiamos hacer esto para cada valor de lineasProcesar ya que cada uno tiene datos completamente distintos
//usamos un for
$i=0; //valor de NUM_LINEA_ALBARAN
foreach($lineasProcesar as $lineas){
    //antes de montar la consulta entera, tenemos que seleccionar todos los datos
    $consulta = "SELECT * FROM lineas_pedidos WHERE NUM_LINEA_PEDIDO = :linea AND COD_PEDIDO = :pedido";
    //esto nos va a dar todos los datos relevantes a lineas_pedidos: NUM_LINEA_PEDIDO, COD_CLIENTE, PRECIO, CANTIDAD, COD_USUARIO_GESTION, COD_PEDIDO, COD_ARTICULO
    //usaremos COD_ARTICULO para sacar DESCUENTO y IVA en la siguiente consulta
    //es decir, solo con esta consulta y la siguiente, tenemos todos los datos listos para procesar esta linea a albarán
    $resultado = $conexion->prepare($consulta);
    $parametros = [":linea" => $lineas, ":pedido" => $codPedido];
    $resultado->execute($parametros);
    $datos = $resultado->fetch(PDO::FETCH_ASSOC);
    if(count($datos) > 0){
        //hacemos la segunda consulta a partir de los datos de la primera
        $consulta = "SELECT DESCUENTO, IVA FROM articulos WHERE COD_ARTICULO = :articulo";
        $parametros = [":articulo" => $datos['COD_ARTICULO']];
        $resultado = $conexion->prepare($consulta);
        $resultado->execute($parametros);
        $datosArticulo = $resultado->fetch(PDO::FETCH_ASSOC);
        if(count($datosArticulo) > 0){
            //creamos un albarán
            $consulta = "INSERT INTO albaranes (COD_CLIENTE, FECHA, GENERADO_DE_PEDIDO, CONCEPTO) VALUES (:codcli, :fecha, :generado, :concepto)";
            $parametros = [":codcli" => $datos["COD_CLIENTE"], ":fecha" => date("Y-m-d H:i:s"), ":generado" => "SI", ":concepto" => $_POST['concepto']];
            $resultado = $conexion->prepare($consulta);
            $resultado->execute($parametros);
            if($resultado->rowCount() > 0){
                //seleccionamos el ID del albaran (autoincrement) y lo usamos para poner el codigo de la linea de albaran
                $consulta = "SELECT MAX(COD_ALBARAN) as ID_MAX FROM albaranes";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $id = $resultado->fetch(PDO::FETCH_ASSOC);

                //Tenemos todos los datos y estamos listos para hacer el procesado final
                $consulta = "INSERT INTO lineas_albaran (
                                        NUM_LINEA_ALBARAN,
                                        COD_CLIENTE,
                                        COD_ALBARAN,
                                        PRECIO,
                                        CANTIDAD,
                                        DESCUENTO,
                                        IVA,
                                        NUM_LINEA_PEDIDO,
                                        COD_PEDIDO,
                                        COD_ARTICULO,
                                        COD_USUARIO_GESTION
                                        )
                                        VALUES
                                        (
                                        :numalb,
                                        :codcli,
                                        :codalb,
                                        :precio,
                                        :cant,
                                        :desc,
                                        :iva,
                                        :numped,
                                        :codped,
                                        :codart,
                                        :codusu
                                        )";
                $parametros = [
                    ":numalb" => $i,
                    ":codcli" => $datos['COD_CLIENTE'],
                    ":codalb" => $id['ID_MAX'],
                    ":precio" => $datos['PRECIO'],
                    ":cant" => $datos['CANTIDAD'],
                    ":desc" => $datosArticulo["DESCUENTO"],
                    ":iva" => $datosArticulo["IVA"],
                    ":numped" => $datos['NUM_LINEA_PEDIDO'],
                    ":codped" => $datos['COD_PEDIDO'],
                    ":codart" => $datos['COD_ARTICULO'],
                    ":codusu" => $_SESSION['gestor']['COD_USUARIO_GESTION']
                ];
                $resultado = $conexion->prepare($consulta);
                $resultado->execute($parametros);
                if($resultado->rowCount() > 0){
                    //teoricamente, al haber introducido estos datos en la linea del albaran, el resto de restricciones se activan
                }
                else{
                    $json['error'] = "Fallo al crear linea $i seccion 3";
                }

            }
            else{
                $json['error'] = "Fallo al crear albarán";
            }

        }
        else{
            $json['error'] = "Fallo al crear linea $i seccion 2";
        }
    }
    else{
        $json['error'] = "Fallo al crear linea $i seccion 1";
    }
    $i++;
}


if(empty($json['error'])){//sin errores
    $json['success'] = "Albarán creado con éxito.";
}
echo json_encode($json);
