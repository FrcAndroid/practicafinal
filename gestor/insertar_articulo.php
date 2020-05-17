<?php
//aqui insertaremos un nuevo artículo
include 'inicio_gestion.php';
include '../base_datos.php';

if(isset($_POST['enviar'])){
    $nombre = $_POST['nombre'];
    $desc = $_POST['desc'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $iva = $_POST['iva'];
    isset($_POST['img'])? $img = $_POST['img'] : $img = null;

    DEFINE('USUARIO', 'GESTOR');
    $conexion = conectar(USUARIO);
    $consulta1 = "SELECT * FROM articulos WHERE NOMBRE = :nom";
    $parametros1 = [":nom" => $nombre];
    $resultado = $conexion->prepare($consulta1);
    $resultado->execute($parametros1);
    if(count($resultado->fetchAll(PDO::FETCH_ASSOC)) > 0){
        echo "Artículo duplicado.";
    }
    else{
        $consulta2 = "INSERT INTO articulos (NOMBRE, DESCRIPCION, PRECIO, DESCUENTO, IVA, IMAGEN) VALUES (:nom, :desc, :precio, :descuento, :iva, :img)";
        $parametros2 = [
            ":nom" => $nombre,
            ":desc" => $desc,
            ":precio" => $precio,
            ":descuento" => $descuento,
            ":iva" => $iva,
            ":img" => $img
        ];
        $resultado = $conexion->prepare($consulta2);
        $resultado->execute($parametros2);
        if($resultado->rowCount() > 0){
            echo "Artículo añadido con éxito.";
        }
        else{
            echo "Ha ocurrido un problema al añadir el artículo.";
        }
    }



}

?>
<h1 class="offset-md-3">Insertar nuevo artículo</h1>
    <form method="post" action=<?=$_SERVER['PHP_SELF']?>>
        <label for="nombre" class="required  offset-md-3 col-form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control col-md-4 offset-md-3" required value=<?= isset($nombre)? "'$nombre'" : ''?>>

        <label for="desc"  class="required  offset-md-3 col-form-label">Descripción</label>
        <input type="text" name="desc" id="desc" class="form-control col-md-4 offset-md-3" required value=<?= isset($desc)? "'$desc'" : ''?>>

        <label for="precio"  class="required  offset-md-3 col-form-label">Precio</label>
        <input type="number" name="precio" id="precio" class="form-control col-md-4 offset-md-3" required value=<?= isset($precio)? $precio : ''?>>

        <label for="descuento"  class="required  offset-md-3 col-form-label">Descuento</label>
        <input type="number" name="descuento" id="descuento" class="form-control col-md-4 offset-md-3" required value=<?= isset($descuento)? $descuento : ''?>>

        <label for="iva" class="required  offset-md-3 col-form-label">IVA</label>
        <input type="number" name="iva" id="iva" class="form-control col-md-4 offset-md-3" required value=<?= isset($iva)? $iva : ''?>>

        <label for="img" class="offset-md-3 col-form-label">Imagen (opcional)</label>
        <input type="text" name="img" id="img" class="form-control col-md-4 offset-md-3" value=<?= isset($img)? $img : ''?>>
        <br>
        <input  class=" btn-info col-md-2 offset-md-4" type="submit" name="enviar" id="enviar" class="btn-info" value="Insertar Artículo">
