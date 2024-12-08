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
            <div class="table__usuarios">
                <?php if (!empty($data)) : ?>
                    <table>
                        <thead>
                            <th>ID</th>
                            <th>Nombre de Usuario</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $usuario) : ?>
                                <tr>
                                    <td><?= $usuario['id'] ?></td>
                                    <td><?= $usuario['usuario'] ?></td>
                                    <td>
                                        <a href="/usuarios/edit/<?= $usuario['id'] ?>">Editar</a>
                                        <a href="/usuarios/delete/<?= $usuario['id'] ?>">Borrar</a>
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
                    <?php if ($_GET['page'] >= 2) : ?>
                        <a href="/usuarios?page=<?php echo $_GET['page'] - 1; ?>">Anterior</a>
                        <?php endif; ?>
                        <a href="/usuarios?page=<?php echo $_GET['page'] + 1; ?>">Siguiente</a>
                </div>
            </div>
        </main>
    </div>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    <?php

    ?>
</body>

</html>