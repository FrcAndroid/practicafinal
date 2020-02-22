cd<?php

if(isset($_POST['usuario'])){
  define("PASSWORD",""); 
  define("USUARIO",$_POST['usuario']);
  define("BB_DD","trabajo_daw");
  
  function conectar(){
  $conexion=null;
    try{
      $opciones=  array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );	
      $conexion = new PDO('mysql:host=localhost;dbname='. BB_DD , USUARIO, PASSWORD, $opciones);
    }catch(Exception $e){
    echo "Ocurrió algo con la base de datos: " . $e->getMessage();
    }
    return $conexion;
  }
}

?>

