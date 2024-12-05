<?php

use app\Gestion\Carrito;
use app\Producto\Producto;
use app\Producto\Ropa;

$carrito = new Carrito();

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

/**
 * Funcion que sirve para comprobar y filtrar los valores que se han recibido de un formulario
 */
function filtrado(String $datos): string
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}


?>

<div class="main__carrito">
    <div class="productos">

        <?php

        if (isset($_POST["eliminar"])) {
            $csrf_token = isset($_POST['token']) ? filtrado($_POST['token']) : '';
            if ($csrf_token !== $_SESSION['token']) {
                die('Token CSRF inválido');
            }

            $idProdEliminar = filtrado($_POST["producto_eliminar"]);

            $carrito->eliminarProducto($idProdEliminar);
        }

        if (isset($_POST["vaciar"])) {
            if($_SESSION['token'] !== $_POST['token']) {
                die('Token CSRF inválido');
            }
            $carrito->vaciarCarrito();
            $carrito->mostrarCarrito();
        } else {
            $carrito->mostrarCarrito();
        }

        ?>

    </div>
    <div class="opciones">
        <div class="control">
            <?php

            $descuentoTotal = 10;
            $precioTotal = $carrito->calcularTotal();

            ?>
            <p>Cantidad de productos: <?php echo $carrito->getCantidad() ?></p>
            <p>Precio Total: <?php echo $carrito->calcularTotal() ?> €</p>
            <p>Descuento: <?php echo $descuentoTotal ?>%</p>
            <p>Precio con descuento: <?php echo $carrito->aplicarDescuento($precioTotal, $descuentoTotal) ?> €</p>
        </div>
        <div class="botones">
            <form action="carrito" method="post" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"></input>
                <input type="submit" name="vaciar" class="button" value="Vaciar Carrito"></input>
            </form>
        </div>
    </div>
</div>