<?php
include '../base_datos.php';
include 'control_sesion_gestor.php';
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
    if($user = $resultado->fetch(PDO::FETCH_ASSOC)){
        //usamos los parametros de usuario para añadir a cliente, empezamos transaccion
        try{
            $conexion->beginTransaction();
            $consulta1 = "INSERT INTO clientes
            (CIF_DNI, RAZON_SOCIAL, DOMICILIO_SOCIAL, CIUDAD, EMAIL, TELEFONO, NICK, CONTRASEÑA)
            VALUES (:cif, :rsoc, :dsoc, :ciu, :mail, :tlf, :nick, :pass)";
            $parametros = [
                ":rsoc" => $user['RAZON_SOCIAL'],
                ":cif" => $user['CIF_DNI'],
                ":dsoc" => $user['DOMICILIO_SOCIAL'],
                ":ciu" => $user['CIUDAD'],
                ":tlf" => $user['EMAIL'],
                ":mail" => $user['TELEFONO'],
                ":nick" => $user['NICK'],
                ":pass" => $user['CONTRASEÑA']
            ];
            $resultado = $conexion->prepare($consulta1);
            /*$resultado->bindParam(":rsoc", $user['RAZON_SOCIAL']);
            $resultado->bindParam(":cif", $user['CIF_DNI']);
            $resultado->bindParam(":dsoc", $user['DOMICILIO_SOCIAL']);
            $resultado->bindParam(":ciu", $user['CIUDAD']);
            $resultado->bindParam(":tlf", $user['EMAIL']);
            $resultado->bindParam(":mail", $user['TELEFONO']);
            $resultado->bindParam(":nick", $user['NICK']);
            $resultado->bindParam(":pass", $user['CONTRASEÑA']);*/

            $resultado->execute($parametros);

            if($resultado->rowCount() > 0){
                //solo nos falta eliminar la solicitud
                $consulta2 = "DELETE FROM solicitudes WHERE ID_SOLICITUD = :cod";
                $resultado = $conexion->prepare($consulta2);
                $parametros = [":cod" => $cod];
                $resultado->execute($parametros);

                if($resultado->rowCount()>0){
                    $conexion->commit();
                    $json['success'] = true;

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
            $json['success'] = false;
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

    echo json_encode($json);
}