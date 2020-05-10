<?php
//recibes codigo de articulo y puedes modificar
include 'inicio_gestion.php';
include '../base_datos.php';

DEFINE('USUARIO', 'GESTOR');
if(isset($_REQUEST['codart'])){
    $codart = $_REQUEST['codart']; //usamos request para recibirlo venga de get (otra página) o post (este formulario)
    if(isset($_POST['modificar'])){
        //comprobamos que codart no sea empty
        if($codart == ''){
            echo "No se encuentra el código del artículo y no se puede modificar.";
        }
        else{
            //recibimos el resto de parametros
            $nombre = $_POST['nombre'];
            $desc = $_POST['desc'];
            $precio = $_POST['precio'];
            $descuento = $_POST['descuento'];
            $iva = $_POST['iva'];
            $img = $_POST['img'];
            $activo = $_POST['activo'];

            $conexion = conectar(USUARIO);
            $consulta = "UPDATE articulos SET 
                            NOMBRE = :nom,
                            DESCRIPCION = :desc,
                            PRECIO = :prec,
                            DESCUENTO = :descuento,
                            IVA = :iva,
                            IMAGEN = :img,
                            ACTIVO = :activo
                            
                        WHERE COD_ARTICULO = :codart
                        ";
            $parametros = [
                ":nom" => $nombre,
                ":desc" => $desc,
                ":prec" => $precio,
                ":descuento" => $descuento,
                ":iva" => $iva,
                ":img" => $img,
                ":activo" => $activo,
                ":codart" => $codart
            ];
            $resultado = $conexion->prepare($consulta);

            $resultado->execute($parametros);
            if($resultado->rowCount() > 0){
                echo "Artículo modificado con éxito.";

            }
            else{
                echo "Error al modificar el artículo.";
            }

        }
    }
    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM articulos where COD_ARTICULO = :codart";
    $parametros = [":codart" => $codart];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
}
else{
    echo ('Codigo de artículo incorrecto');
}
?>

<h1 class="offset-md-3">Modificar artículo</h1>

<?php while($articulo = $resultado->fetch(PDO::FETCH_ASSOC)){ ?>

<form method="post" action=<?=$_SERVER['PHP_SELF']?>>
    <label for="nombre" class="offset-md-3 col-form-label">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control col-md-4 offset-md-3" required value="<?= isset($articulo['NOMBRE'])? $articulo['NOMBRE'] : ''?>">

    <label for="desc"  class="offset-md-3 col-form-label">Descripción</label>
    <input type="text" name="desc" id="desc" class="form-control col-md-4 offset-md-3" required value="<?= isset($articulo['DESCRIPCION'])? $articulo['DESCRIPCION'] : ''?>">

    <label for="precio"  class="offset-md-3 col-form-label">Precio</label>
    <input type="number" name="precio" id="precio" class="form-control col-md-4 offset-md-3" required value="<?= isset($articulo['PRECIO'])? $articulo['PRECIO'] : ''?>">

    <label for="descuento"  class="offset-md-3 col-form-label">Descuento</label>
    <input type="number" name="descuento" id="descuento" class="form-control col-md-4 offset-md-3" required value="<?= isset($articulo['DESCUENTO'])? $articulo['DESCUENTO'] : ''?>">

    <label for="iva" class="offset-md-3 col-form-label">IVA</label>
    <input type="number" name="iva" id="iva" class="form-control col-md-4 offset-md-3" required value="<?= isset($articulo['IVA'])? $articulo['IVA'] : ''?>">

    <label for="img" class="offset-md-3 col-form-label">Imagen</label>
    <input type="text" name="img" id="img" class="form-control col-md-4 offset-md-3" value="<?= isset($articulo['IMAGEN'])? $articulo['IMAGEN'] : ''?>">

   <label for="activo" class="offset-md-3 col-form-label">Activado</label>
    <input type="radio" name="activo" value="SI" <?PHP if($articulo['ACTIVO'] == "SI") print "checked"?> >
    <label for="si">Si</label>
    <input type="radio" name="activo" value="NO" <?PHP if($articulo['ACTIVO'] == "NO") print "checked"?> >    <label for="no">No</label><br>
    <br>
    <input type="hidden" name="codart" id="codart" value=<?= isset($codart)? $codart: ''?>>
    <input  class=" btn-info col-md-2 offset-md-4" type="submit" name="modificar" id="modificar" value="Modificar Artículo">

<?php } ?>

