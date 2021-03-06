<?php
include 'inicio_clientes.php';
include '../base_datos.php';

//mostramos en tabla las facturas, solo consulta
define("USUARIO", "CLIENTE");


if(!isset($_POST['buscar'])){
    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM facturas WHERE COD_CLIENTE = :cliente";
    $resultado = $conexion->prepare($consulta);
    $parametros = [":cliente" =>  $_SESSION['cliente']['COD_CLIENTE']];
    $resultado->execute($parametros);


}
else{
    //buscamos por pedido, fecha, o ambos

    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM facturas WHERE COD_CLIENTE = :cliente";//string inicial de consulta
    $parametros[":cliente"] = $_SESSION['cliente']['COD_CLIENTE'];

    if(isset($_POST['factura']) && !empty($_POST['factura'])){
        $consulta = $consulta. " AND COD_FACTURA = :factura";
        $parametros[":factura"] = $_POST['factura'];
    }

    if(isset($_POST['fecha'])&& !empty($_POST['fecha'])){
        $fecha = $_POST['fecha'];
        $consulta = $consulta. " AND FECHA LIKE :fecha";
        $parametros[":fecha"] = "$fecha%";
    }


    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);


}


?>
<script src="../moment.min.js"></script>
<link rel="stylesheet" href="../bootstrap-sortable.css">
<script src="../bootstrap-sortable.js"></script>
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Ver facturas</h1>
<form method='post' action=<?=$_SERVER['PHP_SELF']?>>
    <label for="factura">Factura</label>
    <input type='number' name='factura' id='factura'>
    <label for="fecha">Fecha</label>
    <input type='date' name='fecha' id='fecha'>
    <input type='submit' class='btn-info' value='Buscar' id='buscar' name='buscar'>
</form>
<br>


<table id="tabla" class="table table-striped table-bordered table-sm sortable" data-toggle="table">
    <thead>
    <tr>
        <th class="headerSortUp headerSortDown">Código factura
        </th>
        <th class="th-sm">Fecha
        </th>
        <th>
            Descuento factura
        </th>
        <th>
            Concepto
        </th>

    </tr>
    </thead>
    <tbody>
    <?php
    while($factura = $resultado->fetch(PDO::FETCH_ASSOC)){ ?>
    <tr>
        <td><?=$factura['COD_FACTURA']?></td>
        <td><?=$factura['FECHA']?></td>
        <td><?=$factura['DESCUENTO_FACTURA']?></td>
        <td><?=$factura['CONCEPTO']?></td>

    <?php } ?>
    </tbody>
</table>