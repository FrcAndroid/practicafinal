<?php
include 'inicio_clientes.php';
include 'base_datos.php';

define("USUARIO", "CLIENTES");
//enseñamos las lineas del pedido y permitimos que borre las que no estan pasadas a albarán todavía
$id_pedido = $_GET['pedido'];

$conexion = conectar(USUARIO);
$consulta = "SELECT * FROM lineas_pedidos l JOIN articulos a on l.COD_ARTICULO = a.COD_ARTICULO WHERE COD_PEDIDO = :pedido AND COD_CLIENTE = :cliente";
$resultado = $conexion->prepare($consulta);
$parametros = [":pedido" => $id_pedido, ":cliente" => $user];
$resultado->execute($parametros);



?>
<script src="moment.min.js"></script>
<script src="borrar.js"></script>
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Modificar pedidos</h1>
<br>

<table id="tabla" class="table table-striped table-bordered" data-toggle="table" cellspacing="0">
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
    $repetir = true;
    while($pedido = $resultado->fetch(PDO::FETCH_ASSOC)){
    $borrar = true;

    if(isset($_GET['lineas'])){//hay lineas no modificables, el pedido no es borrable
        $lineas = $_GET['lineas'];


        echo "No se puede borrar el pedido al completo porque hay lineas en albarán.";
        for($i=0; $i< count($lineas); $i++){
            if($pedido['NUM_LINEA_PEDIDO'] == $lineas[$i]){
                $borrar = false;
            }
        }
    }
    else{
    if($repetir != false){?>
        <button class="eliminar btn btn-default btn-outline-danger">Borrar pedido</button>

    <?php $repetir = false;} }
    if($borrar == false){?>
    <tr style="opacity: 25%">En albarán
        <td id='pedidoTab' value=<?= $id_pedido ?>>
            <?=$pedido['NUM_LINEA_PEDIDO']?> </td>
        <?php }
        else{?>
    <tr>
        <td value=<?= $id_pedido ?>> <button class="borrar btn btn-default btn-outline-danger">Borrar linea</button>
            <?=$pedido['NUM_LINEA_PEDIDO']?> </td>
        <?php } ?>


        <td headers="COD_ARTICULO"><?=$pedido['COD_ARTICULO']?></td>
        <td headers="CANTIDAD"><?=$pedido['CANTIDAD']?></td>
        <td><?=$pedido['PRECIO']?></td>
        <?php } ?>
    </tbody>
</table>
<button class="btn btn-default btn-outline-dark" onclick="window.history.back();">Volver</button>

