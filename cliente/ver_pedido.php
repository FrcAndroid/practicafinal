<?php
require_once 'inicio_clientes.php';
require_once '../base_datos.php';

//mostramos en tabla los pedidos, enseñando botones para modificar y borrar pedido que nos llevaran a
//poder modificar las LINEAS, pero ahora solo mostramos pedidos
define("USUARIO", "CLIENTE");
$conexion = conectar(USUARIO);
if(!isset($_POST['buscar'])){
    $consulta = "SELECT * FROM pedidos WHERE COD_CLIENTE = :cod";
    $parametros = ["cod" => $_SESSION['cliente']['COD_CLIENTE']];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);


}
else{
    //buscamos por pedido, fecha, o ambos

    $consulta = "SELECT * FROM pedidos WHERE COD_CLIENTE = :cod";
    $parametros = ["cod" => $_SESSION['cliente']['COD_CLIENTE']];
    if(isset($_POST['pedido']) && !empty($_POST['pedido'])){
        $consulta1 = $consulta. " AND COD_PEDIDO = :pedido";
        $consulta = $consulta1;
        $parametros[":pedido"] = $_POST['pedido'];
    }

    if(isset($_POST['fecha'])&& !empty($_POST['fecha'])){
        $fecha = $_POST['fecha'];

        $consulta = $consulta. " AND FECHA = :fecha";

        $parametros[":fecha"] = $fecha;
    }


    $resultado = $conexion->prepare($consulta);
    isset($parametros)? $resultado->execute($parametros)
        :   $resultado->execute();



}

//para saber si hay lineas de pedido en albaran
$consulta1 = "SELECT *
FROM lineas_pedidos p join lineas_albaran a on p.COD_PEDIDO = a.COD_PEDIDO AND p.NUM_LINEA_PEDIDO = a.NUM_LINEA_PEDIDO";
$albaranes = $conexion->prepare($consulta1);
$albaranes->execute();
$arrayAlbaranes = $albaranes->fetchAll(PDO::FETCH_ASSOC);

//para saber si hay albaran en factura
$consulta2 = "SELECT *
FROM  lineas_albaran a join lineas_facturas f on a.NUM_LINEA_ALBARAN = f.NUM_LINEA_ALBARAN AND a.COD_ALBARAN = f.COD_ALBARAN";
$facturas = $conexion->prepare($consulta2);
$facturas->execute();
$arrayFacturas = $facturas->fetchAll(PDO::FETCH_ASSOC);
?>
<script src="../moment.min.js"></script>
<link rel="stylesheet" href="../bootstrap-sortable.css">
<script src="../bootstrap-sortable.js"></script>
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Ver pedidos</h1>
<form method='post' action=<?=$_SERVER['PHP_SELF']?>>
    Pedido <input type='number' name='pedido' id='pedido'> Fecha <input type='date' name='fecha' id='fecha'>
    <input type='submit' class='btn-info' value='Buscar' id='buscar' name='buscar'>
</form>
<br>

<table id="tabla" class="table table-striped table-bordered table-sm sortable" data-toggle="table" cellspacing="0">
    <thead>
    <tr>
        <th class="headerSortUp headerSortDown">Código pedido
        </th>
        <th>Cliente</th>
        <th class="th-sm">Fecha
        </th>
        <th>
            Estado pedido
        </th>

    </tr>
    </thead>
    <tbody>
    <?php
    $i = 0;
    while($pedido = $resultado->fetch(PDO::FETCH_ASSOC)){ ?>
    <tr>
        <td><?= $pedido['COD_PEDIDO'] ?></td>
        <td><?= $pedido['COD_CLIENTE'] ?></td>
        <td><?= $pedido['FECHA'] ?></td>
        <?php
        //aqui comprobamos si el pedido es una factura, un albaran completo, o es modificable
        $esAlbaran = false;
        $esFactura = false;
        //pedido es albaran parcial o completo
        foreach ($arrayAlbaranes as $albaran) {
            //vamos a comprobar si este pedido esta en arrayAlbaranes
            if ($albaran["COD_PEDIDO"] == $pedido["COD_PEDIDO"]) {
                $esAlbaran = true;
                //y en cada albaran, comprobamos si es una factura
                foreach ($arrayFacturas as $factura) {
                    if ($albaran["COD_ALBARAN"] == $factura["COD_ALBARAN"]) {
                        //es una factura
                        $esFactura = true;
                    }
                }
            }
        }
        if ($esFactura == true) {
            ?>
            <td style="color: red">Factura</td>
            <?php
        } elseif ($esAlbaran == true) {
            ?>
            <td style="color: deepskyblue">Albarán parcial o completo</td>
            <td><a class="btn btn-outline-info btn-default"
                   href=<?= "modificar_pedido_gestor.php?pedido=" . $pedido["COD_PEDIDO"] ?>>Modificar pedido</a>
            </td>
            <td><a class="btn btn-outline-danger btn-default"
                   href=<?= "borrar_pedido_gestor.php?pedido=" . $pedido["COD_PEDIDO"] ?>>Borrar pedido</a></td>
            <td><a class="btn btn-outline-warning btn-default"
                   href=<?= "pedido_albaran.php?pedido=" . $pedido["COD_PEDIDO"] ?>>Procesar a albarán</a></td>
        <?php } else {
            ?>
            <td style="color: green;">Sin procesar</td>
            <td><a class="btn btn-outline-info btn-default"
                   href=<?= "modificar_pedido_gestor.php?pedido=" . $pedido["COD_PEDIDO"] . "" ?>>Modificar
                    pedido</a></td>
            <td><a class="btn btn-outline-danger btn-default"
                   href=<?= "borrar_pedido_gestor.php?pedido=" . $pedido["COD_PEDIDO"] . "" ?>>Borrar pedido</a>
            </td>
            <td><a class="btn btn-outline-warning btn-default"
                   href=<?= "pedido_albaran.php?pedido=" . $pedido["COD_PEDIDO"] ?>>Procesar a albarán</a></td>
        <?php }

        }?>
    </tbody>
</table>
