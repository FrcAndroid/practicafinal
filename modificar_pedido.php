<?php
include 'inicio_clientes.php';
include "base_datos.php";
define("USUARIO", "CLIENTES");
//enseñamos las lineas del pedido y permitimos que modifique las que no estan pasadas a albarán todavía
$id_pedido = $_GET['pedido'];

$conexion = conectar(USUARIO);
$consulta = "SELECT * FROM lineas_pedidos l JOIN articulos a on l.COD_ARTICULO = a.COD_ARTICULO WHERE COD_PEDIDO = :pedido AND COD_CLIENTE = :cliente";
$resultado = $conexion->prepare($consulta);
$parametros = [":pedido" => $id_pedido, ":cliente" => $user['COD_CLIENTE']];
$resultado->execute($parametros);



?>
<script src="moment.min.js"></script>
<script src="modificar.js"></script>
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
    <?php while($pedido = $resultado->fetch(PDO::FETCH_ASSOC)){
        $editar = true;
        if(isset($_GET['lineas'])){//hay lineas no modificables
            for($i=0; $i< count($_GET['lineas']); $i++){
                if($pedido['NUM_LINEA_PEDIDO'] == $_GET['lineas'][$i]){//linea no modificable
                    $editar = false;
                }
            }
        }
        var_dump($id_pedido);
        if($editar == false){?>
            <tr style="opacity: 25%">En albarán
        <?php }
        else{?>
            <tr>
        <?php } ?>

        <td value=<?= $id_pedido ?>><?=$pedido['NUM_LINEA_PEDIDO']?></td>
        <td headers="COD_ARTICULO" class="editable" contenteditable=<?php $editar?>><?=$pedido['COD_ARTICULO']?></td>
        <td headers="CANTIDAD" class="editable" contenteditable=<?php $editar?>><?=$pedido['CANTIDAD']?></td>
        <td><?=$pedido['PRECIO']?></td>
        <?php } ?>
    </tbody>
</table>
<button class="btn btn-default btn-outline-dark" onclick="window.history.back();">Volver</button>

