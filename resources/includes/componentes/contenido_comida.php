<div class="card__producto">
    <div class="card__title">
        <?php echo $producto->mostrarDescripcion() ?>
    </div>
    <form class="form_carrito" action="productos" method="post">
        <input type="hidden" name="producto_id" value="<?php echo $value["id"] ?>">
        <input type="hidden" name="producto_tipo" value="comida">
        <input type="hidden" name="comida_id" value="<?php echo $value["id_comida"] ?>">
        <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>">
        <input type="submit" name="agregar" class="card__button" value="Agregar al carrito">
    </form>
</div>