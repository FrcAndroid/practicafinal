<?php
//buscar articulo entre todos los articulos con motor de busqueda
include 'inicio_gestion.php';
include '../base_datos.php';

$parametros = [];
define("USUARIO", 'GESTOR');
//hacemos una busqueda preliminar para saber que articulos son borrables
$conexion = conectar(USUARIO);
$consulta = "SELECT DISTINCT a.COD_ARTICULO FROM articulos a JOIN lineas_pedidos lp ON a.COD_ARTICULO = lp.COD_ARTICULO";
$borrable = $conexion->prepare($consulta);
$borrable->execute();
//tenemos una lista de articulos no borrables, lo guardamos en un array para iterarlo
while($borrar = $borrable->fetch(PDO::FETCH_ASSOC)){
    $arrayBorrables[] = $borrar["COD_ARTICULO"];
}
if(!isset($_POST['buscar'])){
    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM articulos";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

}
else{
    //buscamos por nombre, precio, descuento, iva, codigo, estado

    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM articulos";

    if(isset($_POST['codart']) && !empty($_POST['codart'])){
        if(!empty($parametros)){
            $consulta = $consulta. " AND";
        }
        else{
            $consulta = $consulta. " WHERE";
        }
        $consulta = $consulta. " COD_ARTICULO = :articulo";
        $parametros[":articulo"] = $_POST['codart'];
    }

    if(isset($_POST['nombre'])&& !empty($_POST['nombre'])){
        $nombre = $_POST['nombre'];
        if(!empty($parametros)){
            $consulta = $consulta. " AND";
        }
        else{
            $consulta = $consulta. " WHERE";
        }
        $consulta = $consulta. " NOMBRE LIKE :nom";
        $parametros[":nom"] = "%$nombre%";
    }

    if(isset($_POST['precio'])&& !empty($_POST['precio'])){
        $precio = $_POST['precio'];
        if(!empty($parametros)){
            $consulta = $consulta. " AND";
        }
        else{
            $consulta = $consulta. " WHERE";
        }
        $consulta = $consulta. " PRECIO = :precio";
        $parametros[":precio"] = $nombre;
    }

    if(isset($_POST['descuento'])&& !empty($_POST['descuento'])){
        $descuento = $_POST['descuento'];
        if(!empty($parametros)){
            $consulta = $consulta. " AND";
        }
        else{
            $consulta = $consulta. " WHERE";
        }
        $consulta = $consulta. " DESCUENTO = :descuento";
        $parametros[":descuento"] = $descuento;
    }

    if(isset($_POST['iva'])&& !empty($_POST['iva'])){
        $iva = $_POST['iva'];
        if(!empty($parametros)){
            $consulta = $consulta. " AND";
        }
        else{
            $consulta = $consulta. " WHERE";
        }
        $consulta = $consulta. " IVA LIKE :iva";
        $parametros[":iva"] = $iva;
    }

    if(isset($_POST['activo'])&& !empty($_POST['activo'])){
        $activo = $_POST['activo'];
        if(!empty($parametros)){
            $consulta = $consulta. " AND";
        }
        else{
            $consulta = $consulta. " WHERE";
        }
        $consulta = $consulta. " ACTIVO = :estado";
        $parametros[":estado"] = $activo;
    }

    var_dump($consulta);
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);




}

?>
<script src="../moment.min.js"></script>
<link rel="stylesheet" href="../bootstrap-sortable.css">
<script src="../bootstrap-sortable.js"></script>
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1 class="offset-md-3">Ver artículos</h1>
<form method='post' action=<?=$_SERVER['PHP_SELF']?>>
    <label for="codart" class="offset-md-3 col-form-label">Cod. Artículo</label>
    <input type='number' class="form-control col-md-2 offset-md-3" name='codart' id='codart'>

    <label for="nombre" class="offset-md-3 col-form-label">Nombre</label>
    <input type='text' class="form-control col-md-2 offset-md-3" name='nombre' id='nombre'>

    <label for="precio" class="offset-md-3 col-form-label">Precio</label>
    <input type='number' class="form-control col-md-2 offset-md-3" name='precio' id='precio'>

    <label for="descuento" class="offset-md-3 col-form-label">Descuento</label>
    <input type='number' class="form-control col-md-2 offset-md-3" name='descuento' id='descuento'>

    <label for="iva" class="offset-md-3 col-form-label">IVA</label>
    <input type='number' class="form-control col-md-2 offset-md-3" name='iva' id='iva'>

    <label for="activo" class="offset-md-3 col-form-label">Activado</label>
    <br><input type="radio" class="offset-md-3 col-form-label" id="si" name="activo" value="si">
    <label for="si">Si</label><br>
    <input type="radio" class="offset-md-3 col-form-label" id="no" name="activo" value="no">
    <label for="no">No</label><br>

    <input type='submit' class='btn-info offset-md-3 col-form-label' value='Buscar' id='buscar' name='buscar'>
</form>
<br>

<table id="tabla" class="table table-striped table-bordered table-sm sortable" data-toggle="table" cellspacing="0">
    <thead>
    <tr>
        <th class="headerSortUp headerSortDown">Cod. Artículo
        </th>
        <th class="th-sm">Nombre
        </th>
        <th>
            Descripcion
        </th>
        <th>
            Precio
        </th>
        <th>
            Descuento
        </th>
        <th>
            IVA
        </th>
        <th>
            Activo
        </th>


    </tr>
    </thead>
    <tbody>
    <?php
    while($articulo = $resultado->fetch(PDO::FETCH_ASSOC)){ ?>
    <tr>
        <td><?=$articulo['COD_ARTICULO']?></td>
        <td><?=$articulo['NOMBRE']?></td>
        <td><?=$articulo['DESCRIPCION']?></td>
        <td><?=$articulo['PRECIO']?></td>
        <td><?=$articulo['DESCUENTO']?></td>
        <td><?=$articulo['IVA']?></td>
        <td><?=$articulo['ACTIVO']?></td>
        <td><a class="btn-success text-center" href=<?="modificar_articulo.php?codart=" . $articulo["COD_ARTICULO"].""?>>Modificar Artículo</td>

        <?php
        $permitido = true;
        foreach($arrayBorrables as $artBorrable){

            if($artBorrable == $articulo["COD_ARTICULO"]){
                $permitido = false;
            }
            ?>
        <?php }
        if($permitido == true){ ?>
            <td><a class="btn-danger text-center" href=<?="borrar_articulo.php?codart=" . $articulo["COD_ARTICULO"].""?>>Borrar Artículo</td>
       <?php }
        else{?>
            <td><a class="btn-outline-warning text-center">El artículo se encuentra en uno o varios pedidos</td>

        <?php }?>


                      <?php } ?>
    </tbody>
</table>