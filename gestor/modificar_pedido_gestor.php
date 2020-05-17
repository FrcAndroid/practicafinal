<?php
include 'inicio_gestion.php';
include "../base_datos.php";
define("USUARIO", "GESTOR");
//enseñamos las lineas del pedido y permitimos que modifique las que no estan pasadas a albarán todavía
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
<script src="modificar_gestor.js"></script>
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Modificar pedidos</h1>
<br>

<table id="tabla" class="table table-striped table-bordered" data-toggle="table">
    <thead>
    <tr>
        <th>Nº Linea Pedido
        </th>
        <th class="bg-light">Artículo (editable)
        </th>
        <th class="th-sm bg-light">Cantidad (editable)
        </th>
        <th class="th-sm">Precio
        </th>


    </tr>
    </thead>
    <tbody>
    <?php while($pedido = $resultado->fetch(PDO::FETCH_ASSOC)){
    $editar = true;
    foreach ($lineasProcesadas as $linea) {
        if ($linea["NUM_LINEA_PEDIDO"] == $pedido["NUM_LINEA_PEDIDO"]) {
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

        <td value=<?= $id_pedido ?>><?=$pedido['NUM_LINEA_PEDIDO']?></td>
        <td headers="COD_ARTICULO" class="editable " contenteditable=<?php if($editar == 1){echo "true";}else{echo "false";}?>><?=$pedido['COD_ARTICULO']?></td>
        <td headers="CANTIDAD" class="editable " contenteditable=<?php  if($editar == 1){echo "true";}else{echo "false";}?>><?=$pedido['CANTIDAD']?></td>
        <td><?=$pedido['PRECIO'] * $pedido['CANTIDAD']?></td>
        <?php } ?>
    </tbody>
</table>
<button class="btn btn-default btn-outline-dark" onclick="window.history.back();">Volver</button>

