<?php
include 'inicio_gestion.php';
include '../base_datos.php';

define("USUARIO", "GESTOR");
//enseñamos las lineas del albaran y permitimos que borre las que no estan pasadas a albarán todavía
$id_albaran = $_GET['albaran'];

$conexion = conectar(USUARIO);
$consulta = "SELECT * FROM lineas_albaran l JOIN articulos a on l.COD_ARTICULO = a.COD_ARTICULO WHERE COD_ALBARAN = :albaran";
$resultado = $conexion->prepare($consulta);
$parametros = [":albaran" => $id_albaran];
$resultado->execute($parametros);

$consulta1 = "SELECT NUM_LINEA_ALBARAN FROM lineas_facturas WHERE COD_ALBARAN = :albaran";
//seleccionamos todas las lineas que se encuentren en una factura
$parametros = [":albaran" => $id_albaran];
$procesados = $conexion->prepare($consulta1);
$procesados->execute($parametros);
$lineasProcesadas = $procesados->fetchAll(PDO::FETCH_ASSOC);


?>
<script src="../moment.min.js"></script>
<script src="borrar_gestor.js"></script>
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Borrar albaranes</h1>
<br>

<table id="tabla" class="table table-striped table-bordered" data-toggle="table">
    <thead>
    <tr>
        <th>Nº Linea Albaran
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
    <?php
    if(count($lineasProcesadas)<1) { ?>
        <button class="eliminarAlbaran btn btn-default btn-outline-danger">Borrar albaran</button>
    <?php }  ?>

    <?php while($albaran = $resultado->fetch(PDO::FETCH_ASSOC)){
        $borrar = true;
        foreach ($lineasProcesadas as $linea) {
            if ($linea["NUM_LINEA_ALBARAN"] == $albaran["NUM_LINEA_ALBARAN"]) {
                $borrar = false;
            }
        }?>
        <td><?= $albaran['NUM_LINEA_ALBARAN'] ?> </td>
        <td headers="COD_ARTICULO"><?= $albaran['COD_ARTICULO'] ?></td>
        <td headers="CANTIDAD"><?= $albaran['CANTIDAD'] ?></td>
        <td><?= $albaran['PRECIO'] ?></td>

        <?php if ($borrar != false){ ?>
            <td value=<?= $id_albaran ?>>
            <button class="borrarAlbaran btn btn-default btn-outline-danger">Borrar linea</button>
        <?php }else{?>
            <td value=<?= $id_albaran ?>class="font-weight-bold">En factura
            </td>
        <?php }?>
    <?php } ?>
    </tbody>
</table>
<button class="btn btn-default btn-outline-dark" onclick="window.history.back();">Volver</button>

