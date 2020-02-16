<?php
//include 'portada.php'
include 'base_datos.php';
//en teoria nos hemos conectado con el usuario LIMITADO
//comprobamos la validez de los datos introducidos

if(isset($_POST['alta'])){
    $errores = validarDatos();
    header("Content-Type: application/json");
    echo json_encode($errores);
}


function validarDatos(){//listo para pasar a MVC
    $valido = true; // variable de control para saber si seguimos a introducir la solicitud o llamamos a ajax para mostrar errores
    $errores = [];
//CIF
    if(isset($_POST['cif']) && !empty($_POST['cif'])){
        $CIF = strtoupper($_POST['cif']);
        if(strlen($CIF) == 9){
            $arrayOrganizacion = ['A','B','C','D','E','F','G','H','K','L','M','N','P','Q','S'];
            $org = false;
            foreach($arrayOrganizacion as $indice => $letra){
                if ($CIF[0] == $letra){$org=true;}
            }
            if($org == true){
                //el numero de organizacion es valido
                $codProvincia = $CIF[1] + $CIF[2];
                if ($codProvincia > 99 || $codProvincia < 1 || is_string($codProvincia)){
                    $valido = false;
                }
                else{
                    //codigo de provincia valido
                    $numCorrelativo = $CIF[3] + $CIF[4] + $CIF[5] + $CIF[6] + $CIF[7];
                    if(is_int($numCorrelativo)){
                        $numControl = $CIF[8];
                        if($CIF[0] == 'K' || $CIF[0] == 'P' || $CIF[0] == 'Q' || $CIF[0] == 'S'){
                            if(is_int($numControl)){$valido = false;}
                        }
                        else if($CIF[0] == 'A' || $CIF[0] == 'B' || $CIF[0] == 'E' || $CIF[0] == 'H'){
                            if(is_string($numControl)){$valido = false;}
                        }
                    }
                    else{
                        $valido = false;
                    }
                }
            }
            else{
                $valido = false;
            }

        }
        else{
            $valido = false;
        }

        if($valido == false){
            $errores['cif'] = "CIF no es válido.";
        }
    }
    else{
        $errores['cif'] = "El CIF no puede estar vacío";
        $valido = false;
    }

    if(isset($_POST['nombre']) && !empty($_POST['nombre'])){
        //comprobamos que nombre no contenga números y sea un nombre válido
        $nombre = $_POST['nombre'];
        if(1 === preg_match('~[^a-zA-Z]~', $nombre)){//tiene numeros o carácteres especiales
            $errores['nombre'] = "El nombre no puede contener caracteres no válidos";
            $valido = false;
        }
    }
    else{
        $errores['nombre'] = "El nombre no puede estar vacío";
        $valido = false;
    }

    if(isset($_POST['razonsocial']) && !empty($_POST['razonsocial'])){}
    else{
        $errores['razonsocial'] = "La Razon Social no puede estar vacía";
        $valido = false;
    }

    if(isset($_POST['tlf']) && !empty($_POST['tlf'])){
        //comprobamos si son solo números
        if(1 === preg_match('~[^0-9-]~', $_POST['tlf'])){//tiene letras o carácteres especiales
            $errores['tlf'] = "El teléfono no puede contener caracteres no válidos";
            $valido = false;
        }
    }
    else{
        $errores['tlf'] = "El teléfono no puede estar vacío";
        $valido = false;
    }

    if(isset($_POST['email']) && !empty($_POST['email'])) {
        //el html ya ha comprobado que es un email valido
        //pero ahora vamos a sanitizar el email antes de usarlo como query en la base de datos
        $email = $_POST['email'];
        $clean_email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if($clean_email != $email){//han habido modificaciones
            $errores['email'] = "Hay carácteres no válidos en tu email";
        }
        else{//comprobamos que el email existe o no en la base de datos, tanto en solicitudes como en clientes
            $conexion = conectar();
            $consulta = "SELECT s.EMAIL c.EMAIL FROM solicitudes s FULL JOIN clientes c WHERE EMAIL = :email";
            $conexion->prepare($consulta);
            $resultado = $conexion->execute([":email" => $email]);
            //si hay resultados, el email ya existe en la base de datos
            if($resultado->rowCount() > 0){
                $errores['email'] = "Esta dirección ya ha sido usada";
                $valido = false;
            }
        }
    }
    else{
        $errores['email'] = "El email no puede estar vacío";
        $valido = false;
    }

    if(isset($_POST['nick']) && !empty($_POST['nick'])) {
        //comprobamos si el nick ya existe en la base de datos
        //saneamos el nick para asegurarnos que no tiene inyección
        $nick = $_POST['nick'];
        $clean_nick = filter_var($nick, FILTER_SANITIZE_STRING);
        if($clean_nick != $nick){//han habido modificaciones
            $errores['nick'] = "Hay carácteres no válidos en tu nick";
            $valido = false;
        }
        else{//comprobamos que el nick existe o no en la base de datos, tanto en solicitudes como en clientes
            $conexion = conectar();
            $consulta = "SELECT s.NICK c.NICK FROM solicitudes s FULL JOIN clientes c WHERE NICK = :nick";
            $conexion->prepare($consulta);
            $resultado = $conexion->execute([":nick" => $nick]);
            //si hay resultados, el nick ya existe en la base de datos
            if($resultado->rowCount() > 0){
                $errores['nick'] = "Este nick ya esta en uso";
                $valido = false;
            }
        }
    }
    else{
        $errores['nick'] = "El nick no puede estar vacío";
        $valido = false;
    }

    if(isset($_POST['pass']) && !empty($_POST['pass'])) {
    }
    else{
        $errores['nick'] = "La contraseña no puede estar vacía";
        $valido = false;
    }

    return $errores;
}


?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
  <script src="jquery.js"></script>
  <script src="script.js"></script>
<link rel='stylesheet' type='text/css' href='trabajodaw.css'>
<link rel='stylesheet' type='text/css' href='bootstrap.css'>
</head>
<body>
<h1>Formulario de solicitud de alta</h1>
<form method='post' action=<?=$_SERVER['PHP_SELF']?>>
    <label class="required col-md-2 offset-md-3 col-form-label" for='nombre'>Nombre </label>
        <input type='text' name='nombre' id='nombre'>
<br><br>
    <label class="required col-md-2 offset-md-3  col-form-label " for='cif'>CIF </label>
        <input type='text' name='cif' id='cif'><br><br>
    <label class="required col-md-2  offset-md-3 col-form-label" for='razonsocial'>Razon Social </label>
        <input type='text' name='razonsocial' id='razonsocial'><br><br>
    <label class="required col-md-2  offset-md-3 col-form-label" for='tlf'>Teléfono </label>
        <input type='tel' name='tlf' id='tlf'><br><br>
    <label class="required col-md-2  offset-md-3 col-form-label" for='email'>Correo electrónico </label>
        <input type='email' name='email' id='email'><br><br>
    <label class="required col-md-2  offset-md-3 col-form-label" for='nick'>Nick (debe ser único) </label>
        <input type='text' name='nick' id='nick'><br><br>
    <label class="required col-md-2  offset-md-3 col-form-label" for='pass'>Contraseña </label>
        <input type='pass' name='pass' id='pass'><br><br>
        <input type='submit' id='alta' data-user="alta" class='btn btn-default btn-info'>Solicitar alta</input>
    <input type='hidden' name='usuario' id='usuario' value='LIMITADO'>
</form>
</body>
<!-- esto se comunica primero con ajax -->
