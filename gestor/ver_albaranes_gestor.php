<?php
include 'inicio_gestion.php';
include '../base_datos.php';

//mostramos en tabla los pedidos, enseñando botones para modificar y borrar pedido que nos llevaran a
//poder modificar las LINEAS, pero ahora solo mostramos pedidos
define("USUARIO", "GESTOR");

if(!isset($_POST['buscar'])){
    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM albaranes ";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


}
else{
    //buscamos por pedido, fecha, o ambos

    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM albaranes";//string inicial de consulta

    if(isset($_POST['pedido']) && !empty($_POST['pedido'])){
        $consulta1 = $consulta. " WHERE COD_PEDIDO = :pedido";
        $consulta = $consulta1;
        $parametros[":pedido"] = $_POST['pedido'];
    }

    if(isset($_POST['fecha'])&& !empty($_POST['fecha'])){
        $fecha = $_POST['fecha'];
        if(isset($consulta1)){
            $consulta = $consulta. " AND FECHA = :fecha";
        }
        else{
            $consulta = $consulta. " WHERE FECHA = :fecha";
        }
        $parametros[":fecha"] = "$fecha";
    }

    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);


}

$consulta2 = "SELECT * FROM lineas_albaran a JOIN lineas_facturas f ON a.COD_ALBARAN = f.COD_ALBARAN";
$facturados = $conexion->prepare($consulta2);
$facturados->execute();
$albFacturados = $facturados->fetchAll(PDO::FETCH_ASSOC);

?>
<script src="../moment.min.js"></script>
<link rel="stylesheet" href="../bootstrap-sortable.css">
<script src="../bootstrap-sortable.js"></script>
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Ver albaranes</h1>
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
        <th class="headerSortUp headerSortDown">Código albaran
        </th>
        <th class="headerSortUp headerSortDown">Cliente
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
    while($albaran = $resultado->fetch(PDO::FETCH_ASSOC)){
        $modificar = true;
        //tenemos que saber si este albarán esta facturado
        foreach($albFacturados as $facturado){
            if($albaran["COD_ALBARAN"] == $facturado["COD_ALBARAN"]){
                $modificar = false;
            }
        }?>
    <tr>
        <td><?=$albaran['COD_ALBARAN']?></td>
        <td><?=$albaran['COD_CLIENTE']?></td>
        <td><?=$albaran['FECHA']?></td>
        <td><?=$albaran['CONCEPTO']?></td>
        <?php if($modificar == true){?>
            <td><a class="btn btn-default btn-outline-success" href =<?="modificar_albaran_gestor.php?albaran=" . $albaran["COD_ALBARAN"]. ""?>>Modificar</a></TD>
            <td><a class="btn btn-default btn-outline-danger" href =<?="borrar_albaran_gestor.php?albaran=" . $albaran["COD_ALBARAN"]. ""?>>Borrar</a></TD>
        <?php }else{ ?>
            <td style="color: red">Albarán facturado</td>
        <?php } ?>

        <?php } ?>
    </tbody>
</table>