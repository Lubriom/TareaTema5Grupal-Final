<?php
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'head.php'; ?>
    <title>Ver Usuarios | Tarea_Tema5-Final</title>
</head>

<body>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'header.php'; ?>
    <div class="content">
        <main class="main">
            <div class="table__usuarios">
                <?php if (isset($_GET['p'])) : ?>
                    <?php if (!empty($data)) : ?>
                        <table>
                            <thead>
                                <th>ID</th>
                                <th>Nombre de Usuario</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $usuario) : ?>
                                    <tr>
                                        <td><?= $usuario['id'] ?></td>
                                        <td><?= $usuario['usuario'] ?></td>
                                        <td><?= $usuario['nombre'] ?></td>
                                        <td><?= $usuario['apellidos'] ?></td>
                                        <td><?= $usuario['correo'] ?></td>
                                        <td class="icons__action">
                                            <a href="/usuarios/editar/<?= $usuario['id'] ?>">
                                                Editar
                                            </a>
                                            <a href="/usuarios/delete/<?= $usuario['id'] ?>">
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p>
                            <bold>No se ha podido consultar los registros</bold>
                        </p>
                    <?php endif; ?>
                    <div class="paginacion">
                        <?php if ($_GET['p'] >= 2) : ?>
                            <a class="button__alt" href="/usuarios?p=<?php echo $_GET['p'] - 1; ?>">Anterior</a>
                        <?php endif; ?>
                        <a class="button__alt" href="/usuarios?p=<?php echo $_GET['p'] + 1; ?>">Siguiente</a>
                    </div>
                <?php else : ?>
                    <?php header('Location: /usuarios?p=1'); ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    <?php

    ?>
</body>

</html>