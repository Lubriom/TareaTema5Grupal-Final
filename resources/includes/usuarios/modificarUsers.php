<?php
use App\Models\UsuarioModel;
ob_start();

$conexion = new UsuarioModel();

$errores = [];

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

/**
 * Método para comprobar los datos de un campo
 */
function comprobarErroresMod(array $datos, string $tipoCampo): array
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
$hayErrores = false;
$datosUsuario = [];
if (isset($_POST['modificar']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $datosUsuario['id'] = functionfiltrado($_POST['id']);
    $datosUsuario['nombre'] = functionfiltrado($_POST['nombre']);
    $datosUsuario['nombre'] = ucfirst($datosUsuario['nombre']);
    $datosUsuario['apellido'] = functionfiltrado($_POST['apellido']);
    $datosUsuario['apellido'] = ucfirst($datosUsuario['apellido']);
    $datosUsuario['edad'] = functionfiltrado($_POST['edad']);

    foreach ($datosUsuario as $clave => $campo) {
        $erroresCampo = comprobarErroresMod($datosUsuario, $clave);
        $errores = array_merge($errores, $erroresCampo);
        if (!empty($errores[$clave])) {
            $hayErrores = true;
        }
    }
}
?>

<div class="form__column">
    <div class="form__dato">
        <label>ID del usuario a modificar:</label>
        <input type="text" id="id" name="id">
    </div>
    <?php if (isset($errores['id'])): ?>
        <p class="error"><?php echo $errores['id']; ?></p>
    <?php elseif (!isset($errores['id'])) : ?>
        <span></span>
    <?php endif; ?>
</div>
<div class="form__column">
    <div class="form__dato">
        <label>Nombre</label>
        <input type="text" id="nombre" name="nombre">
    </div>
    <?php if (isset($errores['nombre'])): ?>
        <p class="error"><?php echo $errores['nombre']; ?></p>
    <?php elseif (!isset($errores['id'])) : ?>
        <span></span>
    <?php endif; ?>
</div>
<div class="form__column">
    <div class="form__dato">
        <label>Apellido</label>
        <input type="text" id="apellido" name="apellido">
    </div>
    <?php if (isset($errores['apellido'])): ?>
        <p class="error"><?php echo $errores['apellido']; ?></p>
    <?php elseif (!isset($errores['id'])) : ?>
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
    <?php elseif (!isset($errores['id'])) : ?>
        <span></span>
    <?php endif; ?>
</div>
<input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>">
<input class="button__alt" type="submit" id="modificar" name="modificar" value="Modificar Usuario">

<?php
//Se comprueba que hay errores y se procede a modificar el usuario en la base de datos.
if (!$hayErrores) {
    if (isset($_POST['modificar']) && $_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['token'] == $_SESSION['token']) {
            $datosModificar = [];
            foreach ($datosUsuario as $key => $value) {
                if ($key !== "id") {
                    $datosModificar[$key] = $value;
                }
            }
            $conexion->update($datosUsuario['id'], $datosModificar);
            header("Location: /usuarios");

            exit();
        } else {
            echo 'Token Invalido';
        }
    }
}
