<?php
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'head.php'; ?>
    <title>Inicio | Tarea_Tema5-Final</title>
</head>

<body>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'header.php'; ?>
    <div class="content">
        <main class="main">
            <form class="formulario" action="/register/check" method="post" enctype="multipart/form-data">
                <!-- Campo oculto que envia junto con el formulario el token CSRF. -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
               
                <div class="register__datos">
                    <div class="palabra">
                        <label for="nombre" class="title title--left">Nombre:</label>
                        <input type="text" class="palabra__input" name="nombre" />
                        <?php if (isset($data['nombre'])): ?>
                            <p class="title title--left title--error"><?php echo $data['nombre']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <div class="palabra">
                        <label for="apellidos" class="title title--left">Apellidos:</label>
                        <input type="text" class="palabra__input" name="apellidos" />
                        <?php if (isset($data['apellidos'])): ?>
                            <p class="title title--left title--error"><?php echo $data['apellidos']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <div class="palabra">
                        <label for="user" class="title title--left">Usuario:</label>
                        <input type="text" class="palabra__input" name="user" />
                        <?php if (isset($data['user'])): ?>
                            <p class="title title--left title--error"><?php echo $data['user']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <div class="palabra">
                        <label for="correo" class="title title--left">Correo:</label>
                        <input type="text" class="palabra__input" name="correo" />
                        <?php if (isset($data['correo'])): ?>
                            <p class="title title--left title--error"><?php echo $data['correo']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <div class="palabra">
                        <label for="fech_Nac" class="title title--left">Fecha Nacimiento:</label>
                        <input type="date" class="palabra__input" name="fech_Nac" />
                        <?php if (isset($data['fech_Nac'])): ?>
                            <p class="title title--left title--error"><?php echo $data['fech_Nac']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <div class="palabra">
                        <label for="password" class="title title--left">Contraseña:</label>
                        <input type="password" class="palabra__input" name="password" />
                        <?php if (isset($data['password'])): ?>
                            <p class="title title--left title--error"><?php echo $data['password']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <div class="palabra">
                        <label for="saldo" class="title title--left">Saldo Inicial:</label>
                        <input type="saldo" class="palabra__input" name="saldo" />
                        <?php if (isset($data['saldo'])): ?>
                            <p class="title title--left title--error"><?php echo $data['saldo']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <?php if (isset($data['csrf'])): ?>
                        <p class="title title--left title--error"><?php echo $data['csrf']; ?></p>
                    <?php endif; ?>
                    </p>
                    <div class="boton"> <input class="boton__enviar" type="submit" name="enviar" value="Registrate"></div>
                </div>
            </form>
            <hr class="separador separador-login" />
            <div class="container-down">
                <form class="formulario" action="/login" method="post" enctype="multipart/form-data">
                    <div class="register__datos">
                        <div class="boton">
                            <input class="boton__enviar boton__registro" type="submit" name="registro" value="Iniciar Sesión">
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    <?php

    ?>
</body>

</html>