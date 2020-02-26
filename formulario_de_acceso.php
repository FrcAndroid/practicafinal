<?php include 'portada.php' ?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <script src="jquery.js"></script>
    <script src="alta.js"></script>
    <link rel='stylesheet' type='text/css' href='trabajodaw.css'>
    <link rel='stylesheet' type='text/css' href='bootstrap.css'>
</head>
<body>
<h1 class="text-center">Formulario de solicitud de alta</h1>
<form id='form' class="">
    <label class="required  offset-md-3 col-form-label" for='razonsocial'>Razon Social </label>
    <input type='text' name='razonsocial' id='razonsocial' class="form-control col-md-4 offset-md-3" autocomplete="on"  >
    <label class="required  offset-md-3  col-form-label " for='cif'>CIF </label>
    <input type='text' name='cif' id='cif' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='domiciliosocial'>Domicilio Social </label>
    <input type='text' name='domiciliosocial' id='domiciliosocial' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='ciudad'>Ciudad</label>
    <input type='text' name='ciudad' id='ciudad' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='tlf'>Teléfono </label>
    <input type='tel' name='tlf' id='tlf' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='email'>Correo electrónico </label>
    <input type='email' name='email' id='email' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='nick'>Nick (debe ser único) </label>
    <input type='text' name='nick' id='nick' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <label class="required   offset-md-3 col-form-label" for='pass'>Contraseña </label>
    <input type='password' name='pass' id='pass' class="form-control col-md-4 offset-md-3" autocomplete="on"><br>
    <div class="text-center">
        <input type='submit' id='alta' name="alta" data-user="alta" class='btn btn-default btn-info' value="Solicitar alta">
    </div>
</form>
</body>
<!-- esto se comunica primero con ajax -->