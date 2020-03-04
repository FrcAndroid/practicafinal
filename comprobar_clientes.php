<?php
include 'base_datos.php';
include 'control_sesion.php';
define("USUARIO", "GESTOR");

if(isset($_POST['alta'])){
    //damos a usuario de alta
    $cod = $_POST['cod'];
    $conexion = conectar(USUARIO);
    $consulta = "UPDATE clientes SET ESTADO = 's' WHERE COD_CLIENTE = :cod";
    $parametros = [":cod" => $cod];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    if($resultado->rowCount() > 0){
        $json['success'] = true;
    }
    else{
        $json['success'] = false;
    }
    echo json_encode($json);
}

if(isset($_POST['baja'])){
    //damos a usuario de baja
    $cod = $_POST['cod'];
    $conexion = conectar(USUARIO);
    $consulta = "UPDATE clientes SET ESTADO = 'n' WHERE COD_CLIENTE = :cod";
    $parametros = [":cod" => $cod];
    $resultado = $conexion->prepare($consulta);
    $resultado->execute($parametros);
    if($resultado->rowCount() > 0){
        $json['success'] = true;
    }
    else{
        $json['success'] = false;
    }
    echo json_encode($json);
}

if(isset($_POST['aceptar'])){
    //aceptamos solicitud, eliminamos de solicitudes y añadimos a clientes de alta
    //primero seleccionamos al usuario de la solicitud
    $cod = $_POST['cod'];
    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM solicitudes WHERE ID_SOLICITUD = :cod";
    $resultado = $conexion->prepare($consulta);
    $parametros = [":cod" => $cod];
    $resultado->execute($parametros);
    if($usuario = $resultado->fetch(PDO::FETCH_ASSOC)){
        //usamos los parametros de usuario para añadir a cliente, empezamos transaccion
        try{
            $conexion->beginTransaction();
            $consulta = "INSERT INTO clientes (CIF_DNI, RAZON_SOCIAL, DOMICILIO_SOCIAL, CIUDAD, EMAIL, TELEFONO, NICK, CONTRASEÑA)
                VALUES (:rsoc, :cif, :dsoc, :ciu, :tlf, :mail, :nick, :pass)";
            $parametros = [":rsoc" => $usuario['RAZON_SOCIAL'], ":cif" => $usuario['CIF_DNI'], ":dsoc" => $usuario['DOMICILIO_SOCIAL'], ":ciu" => $usuario['CIUDAD'], ":tlf" => $usuario['EMAIL'], ":mail" => $usuario['TELEFONO'], ":nick" => $usuario['NICK'], ":pass" => $usuario['CONTRASEÑA']];
            $resultado = $conexion->prepare($consulta);
            $resultado->execute($parametros);

            if($introducido = $resultado->fetch(PDO::FETCH_ASSOC)){
                //solo nos falta eliminar la solicitud
                $consulta = "DELETE FROM solicitudes WHERE ID_SOLICITUD = :cod";
                $resultado = $conexion->prepare($consulta);
                $parametros = [":cod" => $cod];
                $resultado->execute();
                if($resultado->rowCount()>0){
                    $conexion->commit();
                }
                else{
                    $json['error'] = "Error al eliminar la solicitud";
                }
            }
            else{
                $json['error'] = "Error al introducir el cliente";
            }
        }


        catch (Exception $e) {
            $conexion->rollBack();
            echo "Failed: " . $e->getMessage();
            $permitido = false;
        }

        if($permitido == true){
            $json['success'] == true;
        }
        else{
            $json['success'] == false;
        }

        echo json_encode($json);

    }
}

if(isset($_POST['rechazar'])){
    //simplemente eliminamos la solicitud
    $cod = $_POST['cod'];
    $conexion = conectar(USUARIO);

    $consulta = "DELETE FROM solicitudes WHERE ID_SOLICITUD = :cod";
    $resultado = $conexion->prepare($consulta);
    $parametros = [":cod" => $cod];
    $resultado->execute($parametros);
    if($resultado->execute() > 0){
        $json['success'] = "Solicitud rechazada.";
    }
    else{
        $json['error'] = "Error al eliminar la solicitud";
    }
}