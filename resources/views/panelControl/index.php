<?php
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'head.php'; ?>
    <title>Editar Usuario | Tarea_Tema5-Final</title>
</head>

<body>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'header.php'; ?>
    <div class="content">
        <main class="main">
            <form class="formulario" action="/usuario/panel/<?php echo $_SESSION['id']; ?>" method="post" enctype="multipart/form-data">
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
            <hr class="separador separador-login" />
            <div class="container-down">
                <form class="formulario" action="/usuario/transaccion/<?php echo $_SESSION['id']; ?>" method="post" enctype="multipart/form-data">
                    <div class="register__datos">
                        <!-- Campo oculto que envia junto con el formulario el token CSRF. -->
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div class="palabra">
                            <label for="idDestino" class="title title--left">Id del destinatario:</label>
                            <input type="text" class="palabra__input" name="idDestino" />
                            <?php if (isset($data[1]['idDestino'])): ?>
                                <p class="title title--left title--error"><?php echo $data[1]['idDestino']; ?></p>
                            <?php endif; ?>
                            </p>
                        </div>
                        <div class="palabra">
                            <label for="saldoEnvio" class="title title--left">Saldo a enviar:</label>
                            <input type="text" class="palabra__input" name="saldoEnvio" />
                            <?php if (isset($data[1]['saldoEnvio'])): ?>
                                <p class="title title--left title--error"><?php echo $data[1]['saldoEnvio']; ?></p>
                            <?php endif; ?>
                            </p>
                        </div>
                        <div class="boton">
                            <input class="boton__enviar boton__registro" type="submit" name="registro" value="Enviar saldo">
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