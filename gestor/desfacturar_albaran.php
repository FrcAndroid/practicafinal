<?php
include "../base_datos.php";
include "inicio_gestion.php";
//en desfacturar factura, recibimos el codigo de la factura y mostramos todas sus lineas,
//las cuales podemos desfacturar individualmente
define("USUARIO", "GESTOR");
$id_factura = $_GET['factura'];

$conexion = conectar(USUARIO);
$consulta = "SELECT * FROM lineas_facturas WHERE COD_FACTURA = :factura";
$resultado = $conexion->prepare($consulta);
$parametros = [":factura" => $id_factura];
$resultado->execute($parametros);

?>
<script src="../moment.min.js"></script>
<script src="borrar_gestor.js"></script>

<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Desfacturar albaranes</h1>
<br>

<table id="tabla" class="table table-striped table-bordered" data-toggle="table">
    <thead>
    <tr>
        <th>Nº Linea Factura
        </th>
        <th>Cliente
        </th>
        <th>Cantidad
        </th>
        <th>Artículo
        </th>
        <th class="th-sm ">Precio
        </th>
        <th class="">Descuento</th>
        <th class="">Iva</th>


    </tr>
    </thead>
    <tbody>
    <?php while($factura = $resultado->fetch(PDO::FETCH_ASSOC)){ ?>
        <tr>

        <td value=<?= $id_factura ?>><?=$factura['NUM_LINEA_FACTURA']?></td>
        <td value=<?= $id_factura ?>><?=$factura['COD_CLIENTE']?></td>
        <td value=<?= $id_factura ?>><?=$factura['CANTIDAD']?></td>
        <td value=<?= $id_factura ?>><?=$factura['COD_ARTICULO']?></td>
        <td><?=$factura['PRECIO']?></td>
        <td><?=$factura['DESCUENTO']?></td>
        <td><?=$factura['IVA']?></td>
        <td><a class="desfacturar btn btn-default btn-outline-danger" value=<?= $factura['COD_FACTURA'] ?>>Desfacturar albarán</a></td>
        <?php } ?>
        </tr>
    </tbody>
</table>
<button class="btn btn-default btn-outline-dark" onclick="window.history.back();">Volver</button>
