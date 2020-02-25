<?php

  define("PASSWORD",""); 
  define("BB_DD","trabajo_daw");
  
  function conectar($usuario){
  $conexion=null;
    try{
      $opciones=  array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );	
      $conexion = new PDO('mysql:host=localhost;dbname='. BB_DD , $usuario, PASSWORD, $opciones);
    }catch(Exception $e){
    echo "Ocurrió algo con la base de datos: " . $e->getMessage();
    }
    return $conexion;
  }

?>

