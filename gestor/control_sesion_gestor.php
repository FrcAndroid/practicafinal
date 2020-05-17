<?php
spl_autoload_register(function ($nombre_clase) {
    include $nombre_clase . '.class.php';
});

session_start();//empezamos la sesión ya creada

if(!isset($_SESSION['gestor'])){//si la sesion no existe, redirigimos a la página en la que creamos la sesión
    header("location:pagina_inicio.php");
}

//incluimos este codigo en todas las paginas para asegurarnos de que hay una sesión creada
