<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if (!isset($_COOKIE['color'])): ?>
    <link rel="stylesheet" href="<?php echo DIRECTORY_SEPARATOR . 'rsc_public' . DIRECTORY_SEPARATOR . "styles" . DIRECTORY_SEPARATOR ?>style.css" />
<?php elseif (isset($_COOKIE['color'])): ?>
    <?php if ($_COOKIE['color'] == 'claro'): ?>
        <link rel="stylesheet" href="<?php echo DIRECTORY_SEPARATOR . 'rsc_public' . DIRECTORY_SEPARATOR . "styles" . DIRECTORY_SEPARATOR ?>style.css" />
    <?php elseif ($_COOKIE['color'] == 'oscuro'): ?>
        <link rel="stylesheet" href="<?php echo DIRECTORY_SEPARATOR . 'rsc_public' . DIRECTORY_SEPARATOR . "styles" . DIRECTORY_SEPARATOR ?>styleDark.css" />
    <?php endif; ?>
<?php endif; ?>