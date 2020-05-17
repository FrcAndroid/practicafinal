<?php
include 'inicio_gestion.php';
include '../base_datos.php';

//mostramos en tabla las facturas, solo consulta
define("USUARIO", "GESTOR");


if(!isset($_POST['buscar'])){
    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM facturas";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


}
else{
    //buscamos por pedido, fecha, o ambos

    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM facturas";//string inicial de consulta
    $parametros = [];
    if(isset($_POST['pedido']) && !empty($_POST['pedido'])){
        $consulta = $consulta. " AND COD_PEDIDO = :pedido";
        $parametros[":pedido"] = $_POST['pedido'];
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
    <script src="modificar_gestor.js"></script>
    <script src="borrar_gestor.js"></script>
    <!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
    <h1>Ver facturas</h1>
    <form method='post' action=<?=$_SERVER['PHP_SELF']?>>
        <label for="pedido">Pedido</label>
        <input type='number' name='pedido' id='pedido'>
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
                Descuento factura (editable)
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
            <td headers="DESCUENTO_FACTURA" contenteditable="true" class="editableFactura bg-light"><?=$factura['DESCUENTO_FACTURA']?></td>
            <td><?=$factura['CONCEPTO']?></td>
           <td> <button class="eliminarFactura btn btn-outline-danger btn-default">Borrar Factura</button>
            <a class="btn btn-outline-warning btn-default col-4" href =<?="desfacturar_albaran.php?factura=" . $factura["COD_FACTURA"]. ""?>>Desfacturar albaranes</a>
            <a class="btn btn-outline-dark btn-default col-4" href =<?="imprimir_factura.php?factura=" . $factura["COD_FACTURA"]. ""?> >Imprimir Factura</a></td>

            <?php } ?>
        </tbody>
    </table><?php
