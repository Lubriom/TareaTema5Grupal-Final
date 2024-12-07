<header class="header">
    <div class="header__title">
        <p>Tarea Tema 5 DAW | Roy, Hector, Mariano</p>
    </div>
    <nav class="header__nav">
        <ul class="nav__list">
            <li class="nav__listItem">
                <a class="nav__link" href="/">Inicio</a>
            </li>
            <li class="nav__listItem">
                <a class="nav__link" href="/crearBD">Crear Base de Datos</a>
            </li>
            <li class="nav__listItem">
                <a class="nav__link" href="/usuarios">Usuarios</a>
            </li>
            <?php if (!isset($_SESSION['nombre'])) : ?>
                <li class="nav__listItem">
                    <a class="nav__link" href="/login">Iniciar Sesion</a>
                </li>
            <?php endif; ?>
            <?php if (isset($_SESSION['nombre'])): ?>
                <li class="nav__listItem">
                    <a class="nav__link" href="/logout">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>