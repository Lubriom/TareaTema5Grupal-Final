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
            <form class="formulario" action="/usuarios/update/<?php echo $data[0]['id']; ?>" method="post" enctype="multipart/form-data">
                <!-- Campo oculto que envia junto con el formulario el token CSRF. -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="register__datos">
                    <div class="palabra">
                        <label for="nombre" class="title title--left">Nombre: <?php echo $data[0]["nombre"] ?></label>
                        <input type="text" class="palabra__input" name="nombre" />
                        <?php if (isset($data[1]['nombre'])): ?>
                            <p class="title title--left title--error"><?php echo $data[1]['nombre']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <div class="palabra">
                        <label for="apellidos" class="title title--left">Apellidos: <?php echo $data[0]["apellidos"] ?></label>
                        <input type="text" class="palabra__input" name="apellidos" />
                        <?php if (isset($data[1]['apellidos'])): ?>
                            <p class="title title--left title--error"><?php echo $data[1]['apellidos']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <div class="palabra">
                        <label for="user" class="title title--left">Usuario: <?php echo $data[0]["usuario"] ?></label>
                        <input type="text" class="palabra__input" name="user" />
                        <?php if (isset($data[1]['user'])): ?>
                            <p class="title title--left title--error"><?php echo $data[1]['user']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <div class="palabra">
                        <label for="correo" class="title title--left">Correo: <?php echo $data[0]["correo"] ?></label>
                        <input type="text" class="palabra__input" name="correo" />
                        <?php if (isset($data[1]['correo'])): ?>
                            <p class="title title--left title--error"><?php echo $data[1]['correo']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <div class="palabra">
                        <label for="fech_Nac" class="title title--left">Fecha Nacimiento: <?php echo $data[0]["fecha_Nac"] ?></label>
                        <input type="date" class="palabra__input" name="fech_Nac" />
                        <?php if (isset($data[1]['fech_Nac'])): ?>
                            <p class="title title--left title--error"><?php echo $data[1]['fech_Nac']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <div class="palabra">
                        <label for="saldo" class="title title--left">Saldo Inicial: <?php echo $data[0]["saldo"] ?></label>
                        <input type="text" class="palabra__input" name="saldo" />
                        <?php if (isset($data[1]['saldo'])): ?>
                            <p class="title title--left title--error"><?php echo $data[1]['saldo']; ?></p>
                        <?php endif; ?>
                        </p>
                    </div>
                    <?php if (isset($data[1]['csrf'])): ?>
                        <p class="title title--left title--error"><?php echo $data[1]['csrf']; ?></p>
                    <?php endif; ?>
                    </p>
                    <div class="boton"> <input class="boton__enviar" type="submit" name="enviar" value="Actualizar"></div>
                </div>
            </form>
        </main>
    </div>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    <?php

    ?>
</body>

</html>