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
                                <?php foreach ($data['usuariosFiltrados'] as $usuario) : ?>
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
                <?php endif; ?>
            </div>
            <form method="POST" action="/usuarios/buscarUsuarios">
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre">
                </div>
                <div>
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" name="apellidos" id="apellidos">
                </div>
                <div>
                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario" id="usuario">
                </div>
                <div>
                    <label for="correo">Correo:</label>
                    <input type="text" name="correo" id="correo">
                </div>
                <div>
                    <label for="saldoMin">Saldo Mínimo:</label>
                    <input type="number" name="saldoMin" id="saldoMin" step="0.01">
                </div>
                <div>
                    <label for="saldoMax">Saldo Máximo:</label>
                    <input type="number" name="saldoMax" id="saldoMax" step="0.01">
                </div>
                <button type="submit">Buscar</button>
            </form>

            <?php if (!empty($mensaje)): ?>
                <p><?= htmlspecialchars($mensaje) ?></p>
            <?php endif; ?>

            <h2>Usuarios encontrados</h2>

            <?php if (isset($usuarios) && count($usuarios) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                <td><?= htmlspecialchars($usuario['apellidos']) ?></td>
                                <td><?= htmlspecialchars($usuario['usuario']) ?></td>
                                <td><?= htmlspecialchars($usuario['correo']) ?></td>
                                <td><?= htmlspecialchars($usuario['saldo']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No se encontraron usuarios que coincidan con los criterios.</p>
            <?php endif; ?>


        </main>
    </div>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    <?php

    ?>
</body>

</html>