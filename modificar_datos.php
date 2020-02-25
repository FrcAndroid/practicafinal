<?php
include 'inicio_clientes.php';
// include 'base_datos.php';

//usamos la variable de sesion para acceder a los valores 
if(!isset($_POST['modificar'])){//primera vez que entra
    $valores = [];
    foreach($user as $key=>$value){
        if($key == "ID_SOLICITUD" || $key == "DNI" || $key == "NICK" || $key == "USUARIO"){
            $valores[$key] = $value;
        }
    }
    //al final tenemos un array de valores modificables
}
else{
    //hacemos otro foreach para saber que valores tenemos que modificar
    foreach($valores as $key=>$value){
        if(isset($_POST[$key])){//tenemos todos los valores en sus keys y los modificamos de forma dinamica
            $key = $_POST[$key];
            $conexion = conectar();
            $consulta = "UPDATE clientes SET $key = $value WHERE $key = :key";
            $resultado = $conexion->prepare($consulta);
            $parametros = [":key"=> $key];
            $resultado->execute($parametros);
            if($datos = $resultado->fetch(PDO::FETCH_ASSOC)){
                echo "Modificación realizada con éxito.";
            }

        }
    }
    
}
?>
<h1>Modifica tus datos</h1>
<form method='post' action=<?=$_SERVER['PHP_SELF']?>>
    <?php
    foreach($valores as $key=>$value){?>
        <label for=<?=$key?>><?=$key?></label>
        <input type='text' id=<?=$key?> name=<?=$key?> value=<?=$value?>>
    <?php } ?>
    <input type='submit' name='modificar' id='modificar' value='Modificar datos'?>