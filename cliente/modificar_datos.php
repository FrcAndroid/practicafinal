<?php
include 'inicio_clientes.php';
include '../base_datos.php';
define("USUARIO", "CLIENTES");
//usamos la variable de sesion para acceder a los valores
$valores = [];
foreach($_SESSION['login'] as $key=>$value){
    if($key == "ID_SOLICITUD" || $key == "CIF_DNI" || $key == "NICK" || $key == "COD_CLIENTE" ||  $key == "ESTADO" ){
    }
    else{
        $valores[$key] = $value;
    }
}
//al final tenemos un array de valores modificables
if(isset($_POST['modificar'])){


            $conexion = conectar(USUARIO);
            $consulta = "UPDATE clientes 
SET RAZON_SOCIAL = :razon,
 DOMICILIO_SOCIAL = :dom,
  CIUDAD = :ciu, EMAIL = :email, TELEFONO = :telefono, CONTRASEÑA = :pass
  WHERE COD_CLIENTE = :cod";
            $resultado = $conexion->prepare($consulta);
            $parametros = [":razon" => $_POST['RAZON_SOCIAL'], ":dom"=> $_POST['DOMICILIO_SOCIAL'], ":ciu"=> $_POST['CIUDAD'], ":email" => $_POST['EMAIL'], ":telefono" => $_POST['TELEFONO'], ":pass" => $_POST['CONTRASEÑA']
             ,":cod" => $_SESSION['cliente']['COD_CLIENTE']];
            $resultado->execute($parametros);
            if($resultado->rowCount() > 0){
                echo "Modificación realizada con éxito.";
                $consulta = "SELECT * FROM clientes WHERE COD_CLIENTE = :cod"; //para actualizar la var de sesion
                $parametros = [":cod" => $_SESSION['cliente']['COD_CLIENTE']];
                $resultado = $conexion->prepare($consulta);
                $resultado->execute($parametros);
                if($usuario = $resultado->fetch(PDO::FETCH_ASSOC)){//hay usuario
                    $_SESSION['cliente'] = $usuario;
                }
            }



}

?>
<h1>Modifica tus datos</h1>
<form method='post' action=<?=$_SERVER['PHP_SELF']?>>
    <?php
    foreach($valores as $key=>$value){?>
        <label class="required  offset-md-3 col-form-label" for=<?=$key?>><?=$key?></label>
        <input class="form-control col-md-4 offset-md-3" type='text' id=<?=$key?> name=<?=$key?> value=<?=$value?>>
    <?php } ?><br>
    <div>
        <input type='submit' id='modificar' name="modificar" class='btn btn-default btn-info offset-md-3' value="Modificar datos">
    </div>

