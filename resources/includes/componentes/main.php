<div class="home">
    <?php if (empty($_SESSION['nombre'])): ?>
        <h3 class="h3"><?php echo "Bienvenido a nuestra página" ?></h3>
    <?php else : ?>
        <h3 class="h3"><?php echo "Bienvenido de nuevo " . $_SESSION['nombre']; ?></h3>
    <?php endif; ?>
</div>