<?php

include 'inicio_gestion.php';
include 'base_datos.php';

//primera pasada, leemos los productos desde base de datos
define("USUARIO", "GESTOR");
$u=USUARIO;
$conexion = conectar($u);
$consulta = "SELECT * FROM articulos";
$resultado = $conexion->prepare($consulta);
$resultado->execute();


?>
    <script src='pedido_gestor.js'></script>

    <h1>Generar pedidos</h1>
<?php while($producto = $resultado->fetch(PDO::FETCH_ASSOC)){//hay productos que enseñar //generamos la estructura de un bloque de pedido?>
    <div id="producto" style=" margin-right: 25px; margin-left: 50px; margin-top: 50px" class="col-md-2 float-left">
        <img src=<?=$producto['IMAGEN']?> alt="img" style="width: 250px; height: 250px">
        <b><?=$producto['NOMBRE']?></b>
        <div class="col-md-1 float-right"><?=$producto['PRECIO']?>€</div>
        <i class="float-left"><?=$producto['DESCRIPCION']?></i><br>
        <br>
        <form class="articulo">
            <input type='hidden' name='codArt' id='codArt' value=<?=$producto['COD_ARTICULO']?>>
            Cantidad<br><input class="col-md-4 col-sm-2" type='number' name="cantidad" id="cantidad" min="0">
            <button class="btn btn-default btn-info" id="añadir" value="Añadir">Añadir</button><!--llama a ajax-->
        </form>
    </div>
<?php } ?>