<?php
include "../base_datos.php";
include "inicio_gestion.php";

$lineasProcesadas = [];
//ahora comprobaremos que lineas de este pedido estan procesadas
$id_pedido = $_GET['pedido'];
define('USUARIO', 'GESTOR');
$conexion = conectar(USUARIO);

$conexion = conectar(USUARIO);
$consulta = "SELECT * FROM lineas_pedidos l JOIN articulos a on l.COD_ARTICULO = a.COD_ARTICULO WHERE COD_PEDIDO = :pedido";
$resultado = $conexion->prepare($consulta);
$parametros = [":pedido" => $id_pedido];
$resultado->execute($parametros);

$consulta1 = "SELECT NUM_LINEA_PEDIDO FROM lineas_albaran WHERE COD_PEDIDO = :pedido";
//seleccionamos todas las lineas que se encuentren en el albaran
$parametros = [":pedido" => $id_pedido];
$procesados = $conexion->prepare($consulta1);
$procesados->execute($parametros);
$lineasProcesadas = $procesados->fetchAll(PDO::FETCH_ASSOC);


?>
<script src="proceso_pedido_albaran.js"></script>
<h1>Procesar pedido a albarán</h1>
<br>

<table id="tabla" class="table table-striped table-bordered" data-toggle="table">
    <thead>
    <tr>
        <th>Nº Linea Pedido
        </th>
        <th>Artículo
        </th>
        <th class="th-sm">Cantidad
        </th>
        <th class="th-sm">Precio
        </th>


    </tr>
    </thead>
    <tbody>
    <?php while($pedido = $resultado->fetch(PDO::FETCH_ASSOC)){
    $procesar = true;
    foreach ($lineasProcesadas as $linea) {
        if ($linea["NUM_LINEA_PEDIDO"] == $pedido["NUM_LINEA_PEDIDO"]) {
            $procesar = false;
        }
    } ?>

        <tr>
        <td value=<?= $id_pedido ?>><?= $pedido['NUM_LINEA_PEDIDO'] ?></td>
        <td headers="COD_ARTICULO"><?= $pedido['COD_ARTICULO'] ?></td>
        <td headers="CANTIDAD"><?= $pedido['CANTIDAD'] ?></td>
        <td><?= $pedido['PRECIO'] * $pedido['CANTIDAD'] ?></td>
        <?php if ($procesar == false) { ?>

            <td class="font-weight-bold">
                Procesado en albarán
            </td>

        <?php
        } else { ?>
            <td>
                <button class="proceso btn-success btn-default btn" value="<?= $pedido['NUM_LINEA_PEDIDO'] ?>">
                    Procesar
                </button>
            </td>

        <?php }
        }   ?>
    </tbody>
</table>
<button class="procesofinal btn-success btn-default btn" value="<?=$id_pedido?>">Procesar pedido a albarán</button>
<button class="btn btn-default btn-outline-dark" onclick="window.history.back();">Volver</button>
