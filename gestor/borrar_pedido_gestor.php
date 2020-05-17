<?php
include 'inicio_gestion.php';
include '../base_datos.php';

    define("USUARIO", "GESTOR");
//enseñamos las lineas del pedido y permitimos que borre las que no estan pasadas a albarán todavía
$id_pedido = $_GET['pedido'];

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
<script src="../moment.min.js"></script>
<script src="borrar_gestor.js"></script>
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Borrar pedidos</h1>
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
    <?php
    if(count($lineasProcesadas)<1) { ?>
        <button class="eliminar btn btn-default btn-outline-danger">Borrar pedido</button>
    <?php }  ?>

   <?php while($pedido = $resultado->fetch(PDO::FETCH_ASSOC)){
    $borrar = true;
    foreach ($lineasProcesadas as $linea) {
        if ($linea["NUM_LINEA_PEDIDO"] == $pedido["NUM_LINEA_PEDIDO"]) {
            $borrar = false;
        }
    }?>
       <tr><td><?= $pedido['NUM_LINEA_PEDIDO'] ?> </td>
    <td headers="COD_ARTICULO"><?= $pedido['COD_ARTICULO'] ?></td>
    <td headers="CANTIDAD"><?= $pedido['CANTIDAD'] ?></td>
    <td><?= $pedido['PRECIO'] ?></td>

    <?php if ($borrar != false){ ?>
    <td value=<?= $id_pedido ?>>
        <button class="borrar btn btn-default btn-outline-danger">Borrar linea</button>
        <?php }else{?>
       <td value="<?= $id_pedido ?>" class="font-weight-bold">En albarán
       <button class="bajaPedido btn btn-default btn-outline-danger" value=<?= $pedido['NUM_LINEA_PEDIDO'] ?>>Dar de baja de albarán</button>
       </td>
        <?php }?>
        <?php } ?>
       </tr>

    </tbody>
</table>
<button class="btn btn-default btn-outline-dark" onclick="window.history.back();">Volver</button>

