<?php
//include 'portada.php'
include 'base_datos.php';
//en teoria nos hemos conectado con el usuario LIMITADO
//comprobamos la validez de los datos introducidos
$valido = true;
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
        //añadir error
    }
    else{
        //cif es valido
    }
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
        <button data-user="alta" class='btn btn-default btn-info'>Solicitar alta</button>
    <input type='hidden' name='usuario' id='usuario' value='LIMITADO'>
</body>
<!-- esto se comunica primero con ajax -->
