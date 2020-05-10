<!DOCTYPE html>
    <head>
    <meta charset="UTF-8">
    <?php

    if(!isset($_SESSION['login'])){ ?>
    <script src="jquery.js"></script>
    <script src="popper.js"></script>
    <link rel='stylesheet' type='text/css' href='bootstrap.css'>
    <script src="bootstrap.js"></script>
    <link rel='stylesheet' type='text/css' href='trabajodaw.css'>
    <?php }
    else{?>
    <script src="../jquery.js"></script>
    <script src="../popper.js"></script>
    <link rel='stylesheet' type='text/css' href='../bootstrap.css'>
    <script src="../bootstrap.js"></script>
    <link rel='stylesheet' type='text/css' href='../trabajodaw.css'>

    <?php }?>


    </head>
    <body>
        <div id="portada">
            <p>Empresa S.A</p>
        </div>
