<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'head.php'; ?>
    <title>Inicio | Tarea_Tema5-Final</title>
</head>

<body>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'header.php'; ?>
    <div class="content">
        <main class="main">
            <?php if (empty($_SESSION['nombre'])): ?>
                <h3 class="h3"><?php echo "Bienvenido a nuestra página" ?></h3>
            <?php else : ?>
                <h3 class="h3"><?php echo "Bienvenido de nuevo " . $_SESSION['nombre']; ?></h3>
            <?php endif; ?>
        </main>
    </div>
    <?php require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    <?php

    ?>
</body>

</html>