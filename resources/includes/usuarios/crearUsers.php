<?php

use App\Models\UsuarioModel;



if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}



$errores = [];

/**
 * Método que permite sanitizar los campos
 */
function functionfiltrado(string $datos): string
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

/**
 * Método para comprobar los datos de un campo
 */
function comprobarErrores(array $datos, string $tipoCampo): array
{
    $errores = [];
    switch ($tipoCampo) {
        case 'nombre':
            if (empty($datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Por favor rellene el campo";
            } else if (!preg_match("/^[a-z A-Z]{0,20}$/", $datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Sólo puede estar formado por letras y tener una longitud máxima de 20 caracteres.";
            }
            break;
        case 'apellido':
            if (empty($datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Por favor rellene el campo";
            } else if (!preg_match("/^[a-z A-Z]{0,20}$/", $datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Sólo puede estar formado por letras y tener una longitud máxima de 20 caracteres.";
            }
            break;
        case 'edad':
            if (empty($datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Por favor rellene el campo";
            } else if (!preg_match("/^[\d]{1,}$/", $datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Sólo se puede ingresar números.";
            }
            break;
    }
    return $errores;
}


//Se filran los datos del input
$datosUsuario = [];
if (isset($_POST['register']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $datosUsuario['nombre'] = functionfiltrado($_POST['nombre']);
    $datosUsuario['nombre'] = ucfirst($datosUsuario['nombre']);
    $datosUsuario['apellido'] = functionfiltrado($_POST['apellido']);
    $datosUsuario['apellido'] = ucfirst($datosUsuario['apellido']);
    $datosUsuario['edad'] = functionfiltrado($_POST['edad']);
}

$hayErrores = false;
foreach ($datosUsuario as $clave => $campo) {
    $erroresCampo = comprobarErrores($datosUsuario, $clave);
    $errores = array_merge($errores, $erroresCampo);
    if (!empty($errores[$clave])) {
        $hayErrores = true;
    }
}

?>

<div class="form__column">
    <div class="form__dato">
        <label>Nombre</label>
        <input type="text" id="nombre" name="nombre">
    </div>
    <?php if (isset($errores['nombre'])): ?>
        <p class="error"><?php echo $errores['nombre']; ?></p>
    <?php elseif (!isset($errores['nombre'])) : ?>
        <span></span>
    <?php endif; ?>
</div>
<div class="form__column">
    <div class="form__dato">
        <label>Primer Apellido</label>
        <input type="text" id="apellido" name="apellido">
    </div>
    <?php if (isset($errores['apellido'])): ?>
        <p class="error"><?php echo $errores['apellido']; ?></p>
    <?php elseif (!isset($errores['apellido'])) : ?>
        <span></span>
    <?php endif; ?>
</div>
<div class="form__column">
    <div class="form__dato">
        <label>Edad</label>
        <input type="text" id="edad" name="edad">
    </div>
    <?php if (isset($errores['edad'])): ?>
        <p class="error"><?php echo $errores['edad']; ?></p>
    <?php elseif (!isset($errores['edad'])) : ?>
        <span></span>
    <?php endif; ?>
</div>
<input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>">
<input class="button__alt" type="submit" id="register" name="register" value="Registrar Usuario">

<?php

//Se comprueba que hay errores y se procede insertar el usuario en la base de datos.
if (!$hayErrores) {
    if (isset($_POST['register']) && $_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['token'] == $_SESSION['token']) {
            $conexion = new UsuarioModel();
            $conexion->create($datosUsuario);
            header("Location: /usuarios");
        } else {
            echo 'Token Invalido';
        }
    }
}
?>