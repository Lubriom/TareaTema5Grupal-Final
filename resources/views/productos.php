<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'head.php'; ?>
    <title>Inicio | Tarea_Tema5Grupal</title>
</head>

<body>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'header.php'; ?>
    <div class="content">
        <main class="main">
            <?php ob_start(); ?>
            <?php require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'main.php'; ?>
            <?php require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'sqlsentences.php'; ?>
            <?php ob_end_flush(); ?>
        </main>
    </div>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    <?php

    ?>
</body>

</html>