<?php

require_once '../autoload.php';

require $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . "..");
$dotenv->load();

// Iniciamos la sesión
session_start();
setcookie(session_name(), session_id(), [
    'expires' => time() + 60 * 60, // 1 HORA
]);

require_once '../routes/web.php';