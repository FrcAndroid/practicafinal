<?php
include 'inicio_clientes.php';
include 'base_datos.php';

//mostramos en tabla los pedidos, enseñando botones para modificar y borrar pedido que nos llevaran a
//poder modificar las LINEAS, pero ahora solo mostramos pedidos
define("USUARIO", "CLIENTES");

if(!isset($_POST['buscar'])){
    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM albaranes WHERE COD_CLIENTE = :cliente";
    $resultado = $conexion->prepare($consulta);
    $parametros = [":cliente" => $user];
    $resultado->execute($parametros);


}
else{
    //buscamos por pedido, fecha, o ambos

    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM albaranes WHERE COD_CLIENTE = :cliente";//string inicial de consulta
    $parametros[":cliente"] = $user['COD_CLIENTE'];

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
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Ver albaranes</h1>
<form method='post' action=<?=$_SERVER['PHP_SELF']?>>
    Pedido <input type='number' name='pedido' id='pedido'> Fecha <input type='date' name='fecha' id='fecha'>
    <input type='submit' class='btn-info' value='Buscar' id='buscar' name='buscar'>
</form>
<br>

<table id="tabla" class="table table-striped table-bordered table-sm sortable" data-toggle="table" cellspacing="0">
    <thead>
    <tr>
        <th class="headerSortUp headerSortDown">Código albaran
        </th>
        <th class="th-sm">Fecha
        </th>
        <th>
            Concepto
        </th>

    </tr>
    </thead>
    <tbody>
    <?php
    while($albaran = $resultado->fetch(PDO::FETCH_ASSOC)){ ?>
    <tr>
        <td><?=$albaran['COD_ALBARAN']?></td>
        <td><?=$albaran['FECHA']?></td>
        <td><?=$albaran['CONCEPTO']?></td>
    <?php } ?>
    </tbody>
</table>