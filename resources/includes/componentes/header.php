<header class="header">
    <div class="headertitle">
        <p>Tarea Tema 5 DAW | Roy, Hector, Mariano</p>
    </div>
    <nav class="headernav">
        <ul class="navlist">
            <li class="navlistItem">
                <a class="navlink" href="/">Inicio</a>
            </li>
            <li class="navlistItem">
                <a class="navlink" href="/crearBD">Crear Base de Datos</a>
            </li>
            <?php if (isset($_SESSION['nombre'])): ?>
                <li class="navlistItem">
                    <a class="navlink" href="/usuario/<?php echo $_SESSION['id'] ?>">Usuario</a>

                </li>
            <?php endif; ?>
            <li class="navlistItem">
                <a class="navlink" href="/usuarios?page=0">Lista Usuarios</a>
            </li>
            <?php if (!isset($_SESSION['nombre'])) : ?>
                <li class="navlistItem">
                    <a class="navlink" href="/login">Iniciar Sesion</a>
                </li>
            <?php endif; ?>
            <?php if (isset($_SESSION['nombre'])): ?>
                <li class="navlistItem">
                    <a class="nav__link" href="/logout">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>