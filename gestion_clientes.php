<?php
include "base_datos.php";
include "inicio_gestion.php";
//gestionamos los clientes aqui
define("USUARIO", "GESTOR");
//leemos los clientes de la base de datos
$conexion = conectar(USUARIO);
$consulta = "SELECT * FROM clientes";
$resultado = $conexion->prepare($consulta);
$resultado->execute();

$consulta = "SELECT * FROM solicitudes";
$solicitudes = $conexion->prepare($consulta);
$solicitudes->execute();

?>
<script src="moment.min.js"></script>
<link rel="stylesheet" href="bootstrap-sortable.css">
<script src="bootstrap-sortable.js"></script>
<script src="clientes.js"></script>
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Gestión de clientes</h1>
<br>
<a class="btn btn-warning" href="añadir_cliente.php">Añadir cliente manualmente</a>
<?php if (isset($_GET['success'])){echo "Cliente añadido con éxito.";} ?>

<table id="tabla" class="table table-striped table-bordered table-sm sortable" data-toggle="table" cellspacing="0">
    <thead>
    <tr>
        <th class="headerSortUp headerSortDown">Código cliente
        </th>
        <th class="th-sm">CIF
        </th>
        <th class="th-sm">Razon Social
        </th>
        <th class="th-sm">Domicilio Social
        </th>
        <th class="th-sm">Ciudad
        </th>
        <th class="th-sm">Email
        </th>
        <th class="th-sm">Teléfono
        </th>
        <th class="th-sm">Nick
        </th>
        <th class="th-sm">Contraseña
        </th>
        <th class="th-sm">Estado
        </th>

    </tr>
    </thead>
    <tbody>
    <?php
    $lineas = [];
    $i = 0;
    while($clientes = $resultado->fetch(PDO::FETCH_ASSOC)){ ?>
    <tr>
        <td contenteditable="true"><?=$clientes['COD_CLIENTE']?></td>
        <td contenteditable="true"><?=$clientes['CIF_DNI']?></td>
        <td contenteditable="true"><?=$clientes['RAZON_SOCIAL']?></td>
        <td contenteditable="true"><?=$clientes['DOMICILIO_SOCIAL']?></td>
        <td contenteditable="true"><?=$clientes['CIUDAD']?></td>
        <td contenteditable="true"><?=$clientes['EMAIL']?></td>
        <td contenteditable="true"><?=$clientes['TELEFONO']?></td>
        <td contenteditable="true"><?=$clientes['NICK']?></td>
        <td contenteditable="true"><?=$clientes['CONTRASEÑA']?></td>
        <td>
            <?php if($clientes['ESTADO'] == 'n'){
               echo "<button class='alta btn btn-success'>Dar de Alta</button>";
            }
            if($clientes['ESTADO'] == 's'){
               echo "<button class='baja btn btn-danger'>Dar de Baja</button>";
             }
            ?>
        </td>
        <?php } ?>
    </tbody>
</table>

<h2>Solicitudes pendientes</h2>
<table id="tabla" class="table table-striped table-bordered table-sm sortable" data-toggle="table" cellspacing="0">
    <thead>
    <tr>
        <th class="headerSortUp headerSortDown">ID Solicitud
        </th>
        <th class="th-sm">CIF
        </th>
        <th class="th-sm">Razon Social
        </th>
        <th class="th-sm">Domicilio Social
        </th>
        <th class="th-sm">Ciudad
        </th>
        <th class="th-sm">Email
        </th>
        <th class="th-sm">Teléfono
        </th>
        <th class="th-sm">Nick
        </th>
        <th class="th-sm">Contraseña
        </th>
        <th class="th-sm">Estado
        </th>

    </tr>
    </thead>
    <tbody>
    <?php

    while($solicitud = $solicitudes->fetch(PDO::FETCH_ASSOC)){ ?>
    <tr>
        <td headers="ID_SOLICITUD" class="editable" contenteditable="true"><?=$solicitud['ID_SOLICITUD']?></td>
        <td headers="CIF_DNI" class="editable" contenteditable="true"><?=$solicitud['CIF_DNI']?></td>
        <td headers="RAZON_SOCIAL" class="editable" contenteditable="true"><?=$solicitud['RAZON_SOCIAL']?></td>
        <td headers="DOMICILIO_SOCIAL" class="editable" contenteditable="true"><?=$solicitud['DOMICILIO_SOCIAL']?></td>
        <td headers="CIUDAD" class="editable" contenteditable="true"><?=$solicitud['CIUDAD']?></td>
        <td headers="EMAIL" class="editable" contenteditable="true"><?=$solicitud['EMAIL']?></td>
        <td headers="TELEFONO" class="editable" contenteditable="true"><?=$solicitud['TELEFONO']?></td>
        <td headers="NICK" class="editable" contenteditable="true"><?=$solicitud['NICK']?></td>
        <td headers="CONTRASEÑA" class="editable" contenteditable="true"><?=$solicitud['CONTRASEÑA']?></td>
        <td>
            <button class='aceptar btn btn-success'>Aceptar</button>
            <button class='rechazar btn btn-danger'>Rechazar</button>
        </td>
        <?php } ?>
    </tbody>
</table>