<?php
include "../base_datos.php";
include "inicio_gestion.php";
//primero hacemos un buscado por clientes, ya que una factura solo puede pertenecer a un cliente
define('USUARIO', 'GESTOR');
//la primera consulta es para mostrar lista de clientes
$conexion = conectar(USUARIO);
$consulta = "SELECT * FROM clientes";
$resultado = $conexion->prepare($consulta);
$resultado->execute();




    ?>

<script src="../moment.min.js"></script>
<link rel="stylesheet" href="../bootstrap-sortable.css">
<script src="../bootstrap-sortable.js"></script>
<script src="procesar.js"></script>
<!-- usamos estas librerias para poder usar sort dinamico en las tablas -->
<h1>Procesar albaranes</h1>
<!-- buscador -->
    <label class="col-form-label" for="cliente">Cliente</label>
    <select id='cliente' class="cliente form-control form-inline col-md-2">
        <option selected disabled></option>
        <?php while($cliente = $resultado->fetch(PDO::FETCH_ASSOC)){ ?>
        <option value=<?= $cliente["COD_CLIENTE"] ?>><?= $cliente["COD_CLIENTE"]?> - <?= $cliente["NICK"]?></option>
        <?php } ?>
        </select>

<br>

<table id="tabla" class="table table-striped table-bordered table-sm sortable" data-toggle="table">
    <thead>
    <tr>
        <th class="headerSortUp headerSortDown">Código albaran
        </th>
        <th class="headerSortUp headerSortDown">Cliente
        </th>
        <th class="th-sm">Fecha
        </th>
        <th>
            Concepto
        </th>
        <th></th>

    </tr>
    </thead>
    <tbody>
    <!-- contenedor donde pondremos nuestros datos -->

    </tbody>
</table>
<button class="procesofinal btn-success btn-default btn">Procesar albarán a factura</button>
<button class="btn btn-default btn-outline-dark" onclick="window.history.back();">Volver</button>

