<?php
// Si se puede borrar evidentemente se borra de la base de datos.
include 'inicio_gestion.php';
include '../base_datos.php';
define('USUARIO', 'GESTOR');
//pasamos codart
if(isset($_REQUEST['codart'])){
    $codart = $_REQUEST['codart'];
    //hemos hecho todas las comprobaciones, solo tenemos que pedir la confirmacion del usuario para borrar el objeto
    if(isset($_GET['borrar'])){
        //borramos
        $conexion = conectar(USUARIO);
        $consulta = "DELETE FROM articulos WHERE COD_ARTICULO = :codart";
        $parametros = [":codart" => $codart];
        $resultado = $conexion->prepare($consulta);
        $resultado->execute($parametros);
        if($resultado->rowCount() > 0){
            ?>
            <script type="text/javascript">
                window.location.href = 'buscar_articulo.php';
            </script>
        <?php        }
        else{
            echo "El artículo no se encuentra en la base de datos.";
        }
    }
}
else{
    echo "Error al conseguir el código de artículo.";

}

 ?>
<h1>¿Estas seguro de que quieres borrar el artículo?</h1>
<a href="<?= $_SERVER['PHP_SELF']. '?borrar=true&codart='. $codart?>" class="btn-success col-md-6">Si</a>
<a href="buscar_articulo.php" class="btn-danger col-md-6">No</a>

