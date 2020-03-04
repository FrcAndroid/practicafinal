<?php
include 'inicio_gestion.php';
include 'base_datos.php';

//mostramos en tabla los pedidos, enseñando botones para modificar y borrar pedido que nos llevaran a
//poder modificar las LINEAS, pero ahora solo mostramos pedidos
define("USUARIO", "GESTOR");

if(!isset($_POST['buscar'])){
    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM pedidos";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


}
else{
    //buscamos por pedido, fecha, o ambos

    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM pedidos ";//string inicial de consulta

    if(isset($_POST['pedido']) && !empty($_POST['pedido'])){
        $consulta = $consulta. " WHERE COD_PEDIDO = :pedido";
        $parametros[":pedido"] = $_POST['pedido'];
    }

    if(isset($_POST['fecha'])&& !empty($_POST['fecha'])){
        $fecha = $_POST['fecha'];
        $consulta = $consulta. " WHERE FECHA LIKE :fecha";
        $parametros[":fecha"] = "$fecha%";
    }


    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);


}

//para saber si hay lineas de pedido en albaran
$consulta1 = "SELECT p.COD_PEDIDO, p.NUM_LINEA_PEDIDO 
FROM lineas_pedidos p join lineas_albaran a on p.COD_PEDIDO = a.COD_PEDIDO AND p.NUM_LINEA_PEDIDO = a.NUM_LINEA_PEDIDO";
$albaranes = $conexion->prepare($consulta1);
$albaranes->execute();

//para saber si hay pedido en factura
$consulta2 = "SELECT COD_PEDIDO 
FROM lineas_pedidos p join lineas_albaran a on p.COD_PEDIDO = a.COD_PEDIDO AND p.NUM_LINEA_PEDIDO = a.NUM_LINEA_PEDIDO
 join lineas_facturas f on a.NUM_LINEA_ALBARAN = f.NUM_LINEA_ALBARAN AND a.COD_ALBARAN = f.COD_ALBARAN";
$facturas = $conexion->prepare($consulta1);
$facturas->execute();

?>
    <script src="moment.min.js"></script>
    <link rel="stylesheet" href="bootstrap-sortable.css">
    <script src="bootstrap-sortable.js"></script>
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
            <th class="th-sm">Fecha
            </th>
            <th>
                Estado pedido
            </th>

        </tr>
        </thead>
        <tbody>
        <?php
        $lineas = [];
        $i = 0;
        while($pedido = $resultado->fetch(PDO::FETCH_ASSOC)){ ?>
        <tr>
            <td><?=$pedido['COD_PEDIDO']?></td>
            <td><?=$pedido['FECHA']?></td>
            <?php
            //aqui comprobamos si el pedido es una factura, un albaran completo, o es modificable
            if(count($facturas->fetchAll(PDO::FETCH_ASSOC)) > 0){//pedido es factura
                ?>
                <td style="color: red">Factura</td>
                <?php //no es modificable ni borrable
            }
            else if(count($albaranes->fetchAll(PDO::FETCH_ASSOC)) > 0){//pedido es albaran parcial o completo
                while($albaran = $albaranes->fetch(PDO::FETCH_ASSOC)){
                    $lineas[$i] = $albaran['NUM_LINEA_PEDIDO'];
                    $i++;
                }
                $estado = "Albarán parcial o completo";
                //nos llevamos las lineas devueltas por albaranes para saber que lineas son y no son modificables
                ?>
                <td style="color: deepskyblue;">Albarán parcial o completo</td>
                <td><a class="text-center btn-outline-info btn-default" href =<?="modificar_pedido_gestor.php?pedido=" . $pedido["COD_PEDIDO"]."?lineas=". serialize($lineas)?>>Modificar pedido</a></td>
                <td><a class="text-center btn-outline-danger btn-default" href =<?="borrar_pedido_gestor.php?pedido=" . $pedido["COD_PEDIDO"]. "?lineas=". serialize($lineas)?>>Borrar pedido</a></td>
            <?php }
            else{// pedido es modificable?>
                <td style="color: green;">Modificable</td>
                <td><a class="text-center btn-outline-info btn-default" href =<?="modificar_pedido_gestor.php?pedido=" . $pedido["COD_PEDIDO"].""?>>Modificar pedido</a></td>
                <td><a class="text-center btn-outline-danger btn-default" href =<?="borrar_pedido_gestor.php?pedido=" . $pedido["COD_PEDIDO"]. ""?>>Borrar pedido</a></td>
            <?php }

            ?>

            <?php } ?>
        </tbody>
    </table>