<?php include '../portada.php' ?>
<?php include '../base_datos.php' ?>

<?php
//comprobamos que el login es correcto
if(isset($_POST['iniciar'])){
    define ("USUARIO", "GESTOR");

    $user = $_POST['nombre'];
    $pass = $_POST['pass'];
    $conexion = conectar(USUARIO);
    $consulta = "SELECT * FROM usuarios_gestion WHERE NICK = :user AND CONTRASEÑA = :pass";
    $resultado = $conexion->prepare($consulta);

    $parametros = [
        ":user" => $user,
        ":pass" => $pass
    ];
    $resultado->execute($parametros);
    if($usuario = $resultado->fetch(PDO::FETCH_ASSOC)){//consulta se ha realizado con exito
        //hay usuario, lo metemos en sesión y introducimos el log del acceso
        $consulta = "INSERT INTO accesos (FECHA_HORA_ACCESO, COD_USUARIO) VALUES (:fecha, :cod) ";
        $parametros = [":fecha" => date("Y-m-d H:i:s"), ":cod" => $usuario['COD_USUARIO_GESTION']];
        $resultado = $conexion->prepare($consulta);
        $resultado->execute($parametros);
        if($resultado->rowCount() > 0){
            session_start();
            $_SESSION['gestor'] = $usuario;
            header("location:inicio_gestion.php");
        }

    }
    else{
        echo "Usuario o contraseña inválidos.";
    }
}
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel='stylesheet' type='text/css' href='../trabajodaw.css'>
    <link rel='stylesheet' type='text/css' href='../bootstrap.css'>
</head>
<body>

<h1 class="offset-md-3">Zona de gestor</h1>
<form id='form' method="post" action=<?=$_SERVER['PHP_SELF']?>>
    <label class="required  offset-md-3 col-form-label" for='nombre'>Usuario</label>
    <input type='text' name='nombre' id='nombre' class="form-control col-md-4 offset-md-3" autocomplete="on"  REQUIRED>
    <label class="required   offset-md-3 col-form-label" for='pass'>Contraseña </label>
    <input type='password' name='pass' id='pass' class="form-control col-md-4 offset-md-3" autocomplete="on" REQUIRED><br>
    <div class="offset-md-3">
        <input type='submit' id='iniciar' name="iniciar" class='btn btn-default btn-info' value="Iniciar sesión">
    </div>
    <input type='hidden' name='usuario' id='usuario' value='GESTOR'>
</form>
</body>