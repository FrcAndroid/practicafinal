<?php
include "base_datos.php";
include "inicio_gestion.php";
define("USUARIO", "GESTOR");
//simplemente añadimos el cliente, no hay necesidad de ajax
if(isset($_POST['alta'])){
    $rSocial = $_POST['razonsocial'];
    $CIF = $_POST['cif'];
    $dSocial = $_POST['domiciliosocial'];
    $ciu = $_POST['ciudad'];
    $tlf = $_POST['tlf'];
    $mail = $_POST['email'];
    $nick = $_POST['nick'];
    $pass = $_POST['pass'];

    $conexion = conectar(USUARIO);
    $consulta = "INSERT INTO clientes (CIF_DNI, RAZON_SOCIAL, DOMICILIO_SOCIAL, CIUDAD, EMAIL, TELEFONO, NICK, CONTRASEÑA)
                VALUES (:rsoc, :cif, :dsoc, :ciu, :tlf, :mail, :nick, :pass)";
    $parametros = [":rsoc" => $rSocial, ":cif" => $CIF, ":dsoc" => $dSocial, ":ciu" => $ciu, ":tlf" => $tlf, ":mail" => $mail, ":nick" => $nick, ":pass" => $pass];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    if($resultado->rowCount() > 0){
        header("location:gestion_clientes.php?success=true");
    }

}
?>
<h1 class="text-center">Añade un cliente</h1>
<form id='form' method="post" class="">
    <label class="required  offset-md-3 col-form-label" for='razonsocial'>Razon Social </label>
    <input type='text' name='razonsocial' id='razonsocial' class="form-control col-md-4 offset-md-3" autocomplete="on"  >
    <label class="required  offset-md-3  col-form-label " for='cif'>CIF </label>
    <input type='text' name='cif' id='cif' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='domiciliosocial'>Domicilio Social </label>
    <input type='text' name='domiciliosocial' id='domiciliosocial' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='ciudad'>Ciudad</label>
    <input type='text' name='ciudad' id='ciudad' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='tlf'>Teléfono </label>
    <input type='tel' name='tlf' id='tlf' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='email'>Correo electrónico </label>
    <input type='email' name='email' id='email' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='nick'>Nick (debe ser único) </label>
    <input type='text' name='nick' id='nick' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='pass'>Contraseña </label>
    <input type='password' name='pass' id='pass' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <div class="text-center">
        <input type='submit' id='alta' name="alta" data-user="alta" class='btn btn-default btn-info' value="Solicitar alta">
    </div>
</form>
