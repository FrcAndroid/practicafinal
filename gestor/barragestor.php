<nav class="navbar navbar-expand-lg navbar-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" href="gestion_clientes.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Gestion de clientes
                </a>

            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Gestión de pedidos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="ver_pedido_gestor.php">Gestiona Pedidos</a>
                    <a class="dropdown-item" href="realizar_pedido_gestor.php">Realizar Pedidos</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Gestión de albaranes
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="ver_albaranes_gestor.php">Gestiona Albaranes</a>
                    <a class="dropdown-item" href="albaran_factura.php">Albaran a Factura</a>

                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Gestión de facturas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="ver_facturas_gestor.php">Gestiona Facturas</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Gestión de artículos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="insertar_articulo.php">Insertar artículo</a>
                    <a class="dropdown-item" href="buscar_articulo.php">Buscar artículo</a>



                </div>
            </li>
        </ul>

    </div>
    <p id="user">Bienvenido <?= $_SESSION['gestor']['NICK'] ?> [GESTOR]</p>
    <a class="btn btn-outline-danger my-2 my-sm-0 derecha" href="cerrar_sesionGestor.php">Cerrar sesión</a>
</nav>