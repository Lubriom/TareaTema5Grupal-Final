<div class="home__productos">
    <?php

    use app\Gestion\Carrito;
    use App\Models\ProductoModel;
    use App\Models\RopaModel;
    use App\Models\ElectronicoModel;
    use App\Models\ComidaModel;
    use app\Producto\Comida;
    use app\Producto\Electronico;
    use app\Producto\Ropa;

    $prodRopaModel = new ProductoModel();
    $prodElecModel = new ProductoModel();
    $prodComidaModel = new ProductoModel();
    $transaccionProducto = new ProductoModel();

    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }

    ?>
    <h1 class="title">Sección de Ropa</h1>

    <div class="seccion-ropa">
        <?php
        $productosRopa = $prodRopaModel
            ->select("producto.*", "ropa.talla", "ropa.id_ropa")
            ->join("ropa as ropa", "producto.id", "ropa.id_prod")
            ->get();

        foreach ($productosRopa as $value) {
            $producto = new Ropa($value["id"], $value["nombre"], $value["precio"], $value["talla"], $value["id_ropa"]);
            $productosInstancias['ropa'][$value["id"]] = $producto;

            require 'contenido_ropa.php';
        }
        ?>
    </div>

    <h1 class="title">Sección de Comida</h1>
    <div class="seccion-ropa">
        <?php
        $productosComida = $prodComidaModel
            ->select("producto.*", "comida.caducidad", "comida.id_comida")
            ->join("comida as comida", "producto.id", "comida.id_prod")
            ->get();

        foreach ($productosComida as $value) {
            $caducidad = new DateTime($value["caducidad"]);
            $producto = new Comida($value["id"], $value["nombre"], $value["precio"], $caducidad, $value["id_comida"]);
            $productosInstancias['comida'][$value["id"]] = $producto;

            require 'contenido_comida.php';
        }
        ?>
    </div>

    <h1 class="title">Sección de Electrónicos</h1>
    <div class="seccion-ropa">
        <?php
        $productosElectronico = $prodElecModel
            ->select("producto.*", "electronico.modelo", "electronico.id_elect")
            ->join("electronico as electronico", "producto.id", "electronico.id_prod")
            ->get();


        foreach ($productosElectronico as $value) {
            $producto = new Electronico($value["id"], $value["nombre"], $value["precio"], $value["modelo"], $value["id_elect"]);
            $productosInstancias['electronico'][$value["id"]] = $producto;

            require 'contenido_electronico.php';
        }
        ?>
    </div>

    <?php

    if (isset($_POST["agregar"])) {
        if ($_POST['token'] == $_SESSION['token']) {
            $carrito = new Carrito();
            $productosModel = new ProductoModel();
            $subqueryRopa = new RopaModel();
            $subqueryComida = new ComidaModel();
            $subqueryElectronico = new ElectronicoModel();

            $tipo = $_POST["producto_tipo"];
            $id = $_POST["producto_id"];

            if ($tipo === 'ropa' && isset($productosInstancias['ropa'][$id])) {

                $id_ropa = $_POST["ropa_id"];
                $subConsulta = $subqueryRopa->select("*")->where("ropa.id_ropa", $id_ropa)->get();
                $producto = $productosModel->select("producto.*")->where("id", $subConsulta[0]["id_prod"])->get();
                $ropa = new Ropa($producto[0]["id"], $producto[0]["nombre"], $producto[0]["precio"], $subConsulta[0]["talla"], $subConsulta[0]["id_ropa"]);

                $producto = $ropa;
            } elseif ($tipo === 'comida' && isset($productosInstancias['comida'][$id])) {

                $id_comida = $_POST["comida_id"];
                $subConsulta = $subqueryComida->select("*")->where("comida.id_comida", $id_comida)->get();
                $caducidad = new DateTime($subConsulta[0]["caducidad"]);
                $producto = $productosModel->select("producto.*")->where("id", $subConsulta[0]["id_prod"])->get();
                $ropa = new Comida($producto[0]["id"], $producto[0]["nombre"], $producto[0]["precio"], $caducidad, $subConsulta[0]["id_comida"]);

                $producto = $ropa;
            } elseif ($tipo === 'electronico' && isset($productosInstancias['electronico'][$id])) {

                $id_electronico = $_POST["electronico_id"];
                $subConsulta = $subqueryElectronico->select("*")->where("electronico.id_elect", $id_electronico)->get();
                $producto = $productosModel->select("producto.*")->where("id", $subConsulta[0]["id_prod"])->get();
                $ropa = new Electronico($producto[0]["id"], $producto[0]["nombre"], $producto[0]["precio"], $subConsulta[0]["modelo"], $subConsulta[0]["id_elect"]);

                $producto = $ropa;
            }

            if (isset($producto)) {
                $carrito->agregarProducto($producto);
            }

            header("Location: /productos");
        } else {
            die('Token CSRF inválido');
        }
    }
    ?>
</div>