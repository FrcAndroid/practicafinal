<?php
include 'inicio_gestion.php';
include "../base_datos.php";
define("USUARIO", "GESTOR");
//enseñamos las lineas del pedido y permitimos que modifique las que no estan pasadas a albarán todavía
$id_albaran = $_GET['albaran'];

$conexion = conectar(USUARIO);
$consulta = "SELECT * FROM lineas_albaran WHERE COD_ALBARAN = :albaran";
$resultado = $conexion->prepare($consulta);
$parametros = [":albaran" => $id_albaran];
$resultado->execute($parametros);

$consulta1 = "SELECT NUM_LINEA_ALBARAN FROM lineas_facturas WHERE COD_ALBARAN = :albaran";
//seleccionamos todas las lineas que se encuentren en el albaran
$parametros = [":albaran" => $id_albaran];
$procesados = $conexion->prepare($consulta1);
$procesados->execute($parametros);
$lineasProcesadas = $procesados->fetchAll(PDO::FETCH_ASSOC);


?>
<script src="../moment.min.js"></script>
<script src="modificar_gestor.js"></script>
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Modificar albaranes</h1>
<br>

<table id="tabla" class="table table-striped table-bordered" data-toggle="table">
    <thead>
    <tr>
        <th>Nº Linea Albarán
        </th>
        <th>Cliente
        </th>
        <th>Cantidad
        </th>
        <th>Artículo
        </th>
        <th class="th-sm bg-light">Precio
        </th>
        <th class="bg-light">Descuento</th>
        <th class="bg-light">Iva</th>


    </tr>
    </thead>
    <tbody>
    <?php while($albaran = $resultado->fetch(PDO::FETCH_ASSOC)){
    $editar = true;
    foreach ($lineasProcesadas as $linea) {
        if ($linea["NUM_LINEA_ALBARAN"] == $albaran["NUM_LINEA_ALBARAN"]) {
            $editar = false;
        }
    } ?>
    <?php
    if($editar == false){?>
    <tr style="opacity: 25%">
        <?php }
        else{?>
    <tr>
        <?php } ?>

        <td value=<?= $id_albaran ?>><?=$albaran['NUM_LINEA_ALBARAN']?></td>
        <td value=<?= $id_albaran ?>><?=$albaran['COD_CLIENTE']?></td>
        <td value=<?= $id_albaran ?>><?=$albaran['CANTIDAD']?></td>
        <td value=<?= $id_albaran ?>><?=$albaran['COD_ARTICULO']?></td>
        <td headers="PRECIO" class="editableAlbaran" contenteditable=<?php if($editar == 1){echo "true";}else{echo "false";}?>><?=$albaran['PRECIO']?></td>
        <td headers="DESCUENTO" class="editableAlbaran" contenteditable=<?php if($editar == 1){echo "true";}else{echo "false";}?>><?=$albaran['DESCUENTO']?></td>
        <td headers="IVA" class="editableAlbaran" contenteditable=<?php  if($editar == 1){echo "true";}else{echo "false";}?>><?=$albaran['IVA']?></td>
        <?php } ?>
    </tbody>
</table>
<button class="btn btn-default btn-outline-dark" onclick="window.history.back();">Volver</button>

