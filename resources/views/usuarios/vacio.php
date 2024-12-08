<?php
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'head.php'; ?>
    <title>Tabla vacia | Tarea_Tema5-Final</title>
</head>

<body>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'header.php'; ?>
    <div class="content">
        <main class="main">
            <div class="table__usuarios">
                <p>
                    <bold>La tabla se encuentra vacia</bold>
                </p>
            </div>
        </main>
    </div>
    <?php require "." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "componentes" . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    <?php

    ?>
</body>

</html>