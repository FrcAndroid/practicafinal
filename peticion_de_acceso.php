<?php
//include 'control_sesion.php';
include 'base_datos.php';
//en teoria nos hemos conectado con el usuario LIMITADO

//primero comprobamos si ya esta terminada la comprobación
if(isset($_POST['insertar'])){
    var_dump($_POST['valores']);
    $form = explode("&", $_POST['valores']);//post serializado
    //esto nos da [0] = key=value asi que hacemos otro explode por cada iteracion del form
    $valores = []; //array asociativo con key/value

    for($i=0; $i< count($form); $i++){
        $key_value = explode("=",$form[$i]);
        //nos da dos valores, 0 es la key, 1 el value
        $valores[$key_value[0]] = $key_value[1];
    }


    $terminado = altaSolicitud($valores);//function a la que le pasamos todos los valores ya comprobados y insertamos en la BBDD
    if($terminado == true){
        echo json_encode("Solicitud introducida con éxito, se te contactará en breve.");
    }
    else{
        echo json_encode("Ha ocurrido un problema inesperado al procesar la solicitud, disculpe las molestias.");
    }
}
else{
//comprobamos la validez de los datos introducidos
    $json=[];
//comprobamos cual es el valor que ha pasado la llamada ajax
    if(isset($_POST['razonsocial'])){$errores=razonsocialValido();}
    if(isset($_POST['cif'])){$errores=cifValido();}
    if(isset($_POST['domiciliosocial'])){$errores=domiciliosocialValido();}
    if(isset($_POST['ciudad'])){$errores=ciudadValido();}
    if(isset($_POST['tlf'])){$errores=tlfValido();}
    if(isset($_POST['email'])){$errores=emailValido();}
    if(isset($_POST['nick'])){$errores=nickValido();}
    if(isset($_POST['pass'])){$errores=passValido();}
//var_dump($errores);
    if(empty($errores)){ $json["success"]=true;}
    else {
        $json["success"]=false;
        $json["errores"]=$errores;
    }

    ob_end_clean();
    header("Content-Type: application/json");
    echo json_encode($json);

}

function altaSolicitud($valores){
    //solo tenemos que sacar los valores del form
    $razonsocial = $valores['razonsocial'];
    $cif = $valores['cif'];
    $domiciliosocial = $valores['domiciliosocial'];
    $ciudad = $valores['ciudad'];
    $telefono = $valores['tlf'];
    $email = $valores['email'];
    $nick = $valores['nick'];
    $pass = $valores['pass'];

    $conexion = conectar();
    $consulta = "INSERT INTO solicitudes 
                    (CIF_DNI, RAZON_SOCIAL, DOMICILIO_SOCIAL, CIUDAD, EMAIL, TELEFONO, NICK, CONTRASEÑA)
                    VALUES (:cif,:razonsocial,:domiciliosocial,:ciudad,:email,:tlf,:nick,:pass)
                    ";
    $solicitud = $conexion->prepare($consulta);
    var_dump($nick);
    $parametros=[
        ":razonsocial"=>$razonsocial,
        ":cif"=>$cif,
        ":domiciliosocial"=>$domiciliosocial,
        ":ciudad"=>$ciudad,
        ":email"=>$email,
        ":tlf"=>$telefono,
        ":nick"=>$nick,
        ":pass"=>$pass
    ];
    $solicitud->execute($parametros);
    if($solicitud->rowCount() > 0){
        return true;
    }
    else{
        return false;
    }
}








function cifValido(){
    /*$valido = true;
    if(!empty($_POST['cif'])){
        $cif = strtoupper($_POST['cif']);
        for ($i = 0; $i < 9; $i ++)
        {
            $num[$i] = substr($cif, $i, 1);
        }
        //si no tiene un formato valido devuelve error

        //esta fallando en los preg matches
        if (!preg_match("‘((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)’", $cif)){
            $valido = false;
            $errores['cif'] = "Primera";
        }

        //algoritmo para comprobacion de codigos tipo CIF
        $suma = $num[2] + $num[4] + $num[6];
        for ($i = 1; $i < 8; $i += 2) {
            $suma += substr((2 * $num[$i]),0,1) + substr((2 * $num[$i]), 1, 1);
        }
        $n = 10 - substr($suma, strlen($suma) - 1, 1);

         //comprobacion de CIFs
        if (preg_match("‘^[ABCDEFGHJNPQRSUVW]{1}’", $cif)){
            if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1)){
                $valido = true;

            }
            else{
                $valido = false;
                $errores['cif'] = "Segunda";

            }
        }

        if($valido == false){
            $errores['cif'] = "CIF no válido";
        }
    }
    else{
        $errores['cif'] = "El CIF no puede estar vacío";
    }*/
    //hasta que no se arregle, no comprobamos cif

    return null;
}

function razonsocialValido(){
    if(isset($_POST['razonsocial']) && !empty($_POST['razonsocial'])){
        //comprobamos que nombre no contenga números y sea un nombre válido
        $razonsocial = $_POST['razonsocial'];
        if(1 === preg_match('~[^a-zA-Z]~', $razonsocial)){//tiene numeros o carácteres especiales
            $errores['razonsocial'] = "La razon social no puede contener caracteres no válidos";
            $valido = false;
        }
    }
    else{
        $errores['razonsocial'] = "La razon social no puede estar vacía";
        $valido = false;
    }
    return $errores;
}

function domiciliosocialValido(){
    if(isset($_POST['domiciliosocial']) && !empty($_POST['domiciliosocial'])){}
    else{
        $errores['domiciliosocial'] = "El Domicilio Social no puede estar vacía";
        $valido = false;
    }
    return $errores;
}

function tlfValido(){
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

    return $errores;
}

function emailValido(){
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        //el html ya ha comprobado que es un email valido
        //pero ahora vamos a sanitizar el email antes de usarlo como query en la base de datos
        $email = $_POST['email'];
        $clean_email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if($clean_email != $email){//han habido modificaciones
            $errores['email'] = "Hay carácteres no válidos en tu email";
        }
        else{//comprobamos que el email existe o no en la base de datos, tanto en solicitudes como en clientes
            //pero primero comprobamos si es una dirección de email
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $conexion = conectar();
                $consulta = "SELECT EMAIL
                         FROM solicitudes 
                         WHERE EMAIL = :email";
                $resultado = $conexion->prepare($consulta);
                $emails= $resultado->execute([":email" => $email]);
                //si hay resultados, el email ya existe en la base de datos
                if($emails->rowCount > 0){
                    $errores['email'] = "Esta dirección ya ha sido usada";
                    $valido = false;
                }
            }
            else {
                $errores['email'] = "Este email no tiene un formato válido";
            }

        }
    }
    else{
        $errores['email'] = "El email no puede estar vacío";
        $valido = false;
    }
    return $errores;
}

function nickValido(){
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
            $consulta = "SELECT NICK FROM solicitudes WHERE NICK = :nick";
            $resultado = $conexion->prepare($consulta);
            $nicks = $resultado->execute([":nick" => $nick]);
            //si hay resultados, el nick ya existe en la base de datos
            if($nicks->rowCount > 0){
                $errores['nick'] = "Este nick ya esta en uso";
                $valido = false;
            }
        }
    }
    else{
        $errores['nick'] = "El nick no puede estar vacío";
        $valido = false;
    }

    return $errores;
}

function passValido(){
    if(isset($_POST['pass']) && !empty($_POST['pass'])) {
    }
    else{
        $errores['pass'] = "La contraseña no puede estar vacía";
        $valido = false;
    }


    return $errores;
}

function ciudadValido(){
    if(isset($_POST['ciudad']) && !empty($_POST['ciudad'])) {
    }
    else{
        $errores['ciudad'] = "La ciudad no puede estar vacía";
        $valido = false;
    }


    return $errores;
}


?>