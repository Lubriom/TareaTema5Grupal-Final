<?php
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'head.php'; ?>
    <title>Ver Usuarios | Tarea_Tema5-Final</title>
</head>

<body>
    <?php require ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'header.php'; ?>
    <div class="content">
        <main class="main">
            <div class="table__usuarios">
                <?php if (isset($_GET['p'])): ?>
                    <?php if (!empty($data['usuarios'])): ?>
                        <?php
                        $p = $data['paginaActual'] ?? 1;
                        $totalPaginas = $data['totalPaginas'] ?? 1;
                        ?>
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
                                <?php foreach ($data['usuarios'] as $usuario): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($usuario['id']) ?></td>
                                        <td><?= htmlspecialchars($usuario['usuario']) ?></td>
                                        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                        <td><?= htmlspecialchars($usuario['apellidos']) ?></td>
                                        <td><?= htmlspecialchars($usuario['correo']) ?></td>
                                        <td class="icons__action">
                                            <a href="/usuarios/editar/<?= htmlspecialchars($usuario['id']) ?>">Editar</a>
                                            <a href="/usuarios/delete/<?= htmlspecialchars($usuario['id']) ?>">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if ($totalPaginas > 1): ?>
                            <div class="paginacion">
                                <?php if ($p > 1): ?>
                                    <a class="button__alt" href="/usuarios?p=<?= htmlspecialchars($_GET['p'] - 1) ?>">Anterior</a>
                                <?php endif; ?>
                                <?php if ($p < $totalPaginas): ?>
                                    <a class="button__alt" href="/usuarios?p=<?= htmlspecialchars($_GET['p'] + 1) ?>">Siguiente</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php elseif (!empty($data['usuariosFiltrados'])): ?>
                        <?php
                        $p = $data['paginaActual'] ?? 1;
                        $totalPaginas = $data['totalPaginas'] ?? 1;
                        ?>

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
                                <?php foreach ($data['usuariosFiltrados'] as $usuario): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($usuario['id']) ?></td>
                                        <td><?= htmlspecialchars($usuario['usuario']) ?></td>
                                        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                        <td><?= htmlspecialchars($usuario['apellidos']) ?></td>
                                        <td><?= htmlspecialchars($usuario['correo']) ?></td>
                                        <td class="icons__action">
                                            <a href="/usuarios/editar/<?= htmlspecialchars($usuario['id']) ?>">Editar</a>
                                            <a href="/usuarios/delete/<?= htmlspecialchars($usuario['id']) ?>">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <?php if ($totalPaginas > 1): ?>
                            <div class="paginacion">
                                <?php if ($p > 1): ?>
                                    <a class="button__alt" href="/usuariosFiltrados?p=<?= $data['paginaActual'] - 1 ?>">Anterior</a>
                                <?php endif; ?>
                                <?php if ($p < $totalPaginas): ?>
                                    <a class="button__alt" href="/usuariosFiltrados?p=<?= $data['paginaActual'] + 1 ?>">Siguiente</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <p><strong>No se ha podido consultar los registros</strong></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <form method="POST" action="/usuariosFiltrados?p=1" class="formulario">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <h2 class="title title--left">Filtrar Usuarios</h2>
                <div class="login__datos">
                    <div class="palabra">
                        <label for="nombre" class="title">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="palabra__input" placeholder="Ingresa el nombre">
                        <?php if (isset($data['errores']['nombre'])): ?>
                            <p class="title title--left title--error"><?php echo $data['errores']['nombre']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="palabra">
                        <label for="apellidos" class="title">Apellidos:</label>
                        <input type="text" name="apellidos" id="apellidos" class="palabra__input" placeholder="Ingresa los apellidos">
                        <?php if (isset($data['errores']['user'])): ?>
                            <p class="title title--left title--error"><?php echo $data['errores']['apellido']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="palabra">
                        <label for="usuario" class="title">Usuario:</label>
                        <input type="text" name="user" id="user" class="palabra__input" placeholder="Ingresa el usuario">
                        <?php if (isset($data['errores']['user'])): ?>
                            <p class="title title--left title--error"><?php echo $data['errores']['user']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="palabra">
                        <label for="correo" class="title">Correo:</label>
                        <input type="text" name="correo" id="correo" class="palabra__input" placeholder="Ingresa el correo">
                        <?php if (isset($data['errores']['correo'])): ?>
                            <p class="title title--left title--error"><?php echo $data['errores']['correo']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="palabra">
                        <label for="saldoMin" class="title">Saldo Mínimo:</label>
                        <input type="text" name="saldoMin" id="saldoMin" class="palabra__input" step="0.01" placeholder="Saldo mínimo">
                        <?php if (isset($data['errores']['saldoMin'])): ?>
                            <p class="title title--left title--error"><?php echo $data['errores']['saldoMin']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="palabra">
                        <label for="saldoMax" class="title">Saldo Máximo:</label>
                        <input type="text" name="saldoMax" id="saldoMax" class="palabra__input" step="0.01" placeholder="Saldo máximo">
                        <?php if (isset($data['errores']['saldoMax'])): ?>
                            <p class="title title--left title--error"><?php echo $data['errores']['saldoMax']; ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($data['errores']['csrf'])): ?>
                        <p class="title title--left title--error"><?php echo $data['errores']['csrf']; ?></p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="button__alt">Buscar</button>
            </form>
            <?php if (!empty($mensaje)): ?>
                <p><?= htmlspecialchars($mensaje) ?></p>
            <?php endif; ?>

        </main>
    </div>
    <?php require ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'footer.php'; ?>
</body>

</html>