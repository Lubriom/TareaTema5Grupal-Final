<?php

use app\Models\UsuarioModel;

$conexion = new UsuarioModel();

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

$errores = [];

/**
 * Método para comprobar los datos de un campo
 */
function comprobarErroresDel(array $datos, string $tipoCampo): array
{
    $conexion = new UsuarioModel();
    $usuario = $conexion->find($datos[$tipoCampo]);
    $errores = [];
    switch ($tipoCampo) {
        case 'id':
            if (empty($datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Por favor rellene el campo";
            } else if (!preg_match("/^[\d]{1,}$/", $datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Sólo se puede ingresar números.";
            } else if (empty($usuario)) {
                $errores[$tipoCampo] = "No existe un usuario con este ID";
            }

            break;
    }
    return $errores;
}


//Se filran los datos del input
$hayErrores = false;
$datosUsuario = [];
if (isset($_POST['eliminar']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $datosUsuario['id'] = functionfiltrado($_POST['id']);

    foreach ($datosUsuario as $clave => $campo) {
        $erroresCampo = comprobarErroresDel($datosUsuario, $clave);
        $errores = array_merge($errores, $erroresCampo);
        if (!empty($errores[$clave])) {
            $hayErrores = true;
        }
    }
}

?>

<div class="form__column">
    <div class="form__dato">
        <label>ID del usuario a modificar</label>
        <input type="text" id="id" name="id">
    </div>
    <?php if (isset($errores['id'])): ?>
        <p class="error"><?php echo $errores['id']; ?></p>
    <?php elseif (!isset($errores['id'])) : ?>
        <span></span>
    <?php endif; ?>
</div>
<input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>">
<input class="button__alt" type="submit" id="eliminar" name="eliminar" value="Eliminar Usuario">

<?php

//Se comprueba que hay errores y se procede a eliminar el usuario en la base de datos.
if (!$hayErrores) {
    if (isset($_POST['eliminar']) && $_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['token'] == $_SESSION['token']) {
            $conexion->delete($datosUsuario['id']);

            header('Location: /usuarios');

        } else {
            echo 'Token Invalido';
        }
    }
}
exit();
ob_end_flush();