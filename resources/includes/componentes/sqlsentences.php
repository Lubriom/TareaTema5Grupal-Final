<?php

use App\Models\ProductoModel;

$conexion = new ProductoModel();

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
    $conexion = new ProductoModel();
    $usuario = $conexion->find($datos[$tipoCampo]);
    $errores = [];
    switch ($tipoCampo) {
        case 'id':
            if (empty($datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Por favor rellene el campo";
            } else if (!is_numeric($datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Sólo se puede ingresar números.";
            } else if (empty($usuario)) {
                $errores[$tipoCampo] = "No existe un producto con este ID";
            }
            break;
        case 'descuento':
            echo $datos[$tipoCampo];
            if (empty($datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Por favor rellene el campo";
            } else if (!is_numeric($datos[$tipoCampo])) {
                $errores[$tipoCampo] = "Sólo se puede ingresar números.";
            } else if ($datos[$tipoCampo] < 1 || $datos[$tipoCampo] >= 100) {
                $errores[$tipoCampo] = "El descuento no puede ser inferior a 1 ni superior a 100";
            }
            break;
    }
    return $errores;
}


//Se filran los datos del input
$hayErrores = false;
$datosUsuario = [];
if (isset($_POST['precio_desc']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $datosUsuario['id'] = functionfiltrado($_POST['id']);
    $datosUsuario['descuento'] = functionfiltrado($_POST['descuento']);

    foreach ($datosUsuario as $clave => $campo) {
        $erroresCampo = comprobarErrores($datosUsuario, $clave);
        $errores = array_merge($errores, $erroresCampo);
        if (!empty($errores[$clave])) {
            $hayErrores = true;
        }
    }
}

?>

<!-- Transacción y Procedimientos -->
<div class="home__procedimientos">
    <h1 class="title">Transacción y Procedimientos</h1>

    <!-- Transacción -->
    <div class="seccion-tran">
        <h3 class="title">Ejemplo de Transacción</h3>
        <form class="form" method="post" action="/productos">
            <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>">
            <input class="button__alt" type="submit" id="transaccion" name="transaccion" value="Realizar transacción">
        </form>
    </div>

    <!-- Primer Procedimiento -->
    <div class="seccion-prod1">
        <h3 class="title">Ejemplo de Procedimiento OUT</h3>
        <p class="title"><?php echo "Hay un total de: " . $conexion->contarProductos(); ?></p>
    </div>

    <!-- Segundo Procedimiento -->
    <div class="seccion-prod2">
        <h3 class="title">Ejemplo de procedimiento IN-OUT</h3>
        <h3 class="title"> - Calcular descuento del producto</h3>
        <form class="form form-center" action="productos" method="post">
            <label for="id">Introducir ID</label>
            <input type="text" id="id" name="id">
            <label for="descuento">Introducir Descuento</label>
            <input type="text" id="descuento" name="descuento">
            <?php if (isset($errores['id'])): ?>
                <p class="error">Error campo ID: <?php echo $errores['id']; ?></p>
            <?php elseif (!isset($errores['id'])) : ?>
                <span></span>
            <?php endif; ?>
            <?php if (isset($errores['descuento'])): ?>
                <p class="error">Error campo Descuento: <?php echo $errores['descuento']; ?></p>
            <?php elseif (!isset($errores['descuento'])) : ?>
                <span></span>
            <?php endif; ?>

            <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>">
            <input class="button__alt" type="submit" id="precio_desc" name="precio_desc" value="Realizar descuento" />
        </form>

    </div>
</div>

<?php

if (isset($_POST['transaccion'])) { // Comprobamos si se hizo click en 'Realizar Transaccion'
    if ($_POST['token'] == $_SESSION['token']) {
        $conexion->aniadirProducto();

        header('Location: /productos');
    } else {
        echo 'Token Invalido';
    }
} else if (!$hayErrores) { // Comprobamos si se hizo click en 'Realizar Descuento'
    if (isset($_POST['precio_desc']) && $_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['token'] == $_SESSION['token']) {
            $precio = $conexion->select("precio")->where("id", $_POST["id"])->get();
            echo "Descuento final es: " . $conexion->calcular_precio_con_descuento($precio[0]["precio"], $_POST["descuento"]);
        } else {
            echo 'Token Invalido';
        }
    }
}
exit();
?>