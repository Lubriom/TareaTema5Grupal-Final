<?php
    // Aquí importaremos el modelo usuarios
    use App\Models\UsuarioModel;
    use app\Gestion\Usuario;

    $usuarios = [];
    $conexion = new UsuarioModel();
    foreach ($conexion->all() as $usuariosBD) {
        $usuarios[] = new Usuario($usuariosBD['id'] ,$usuariosBD['nombre'],$usuariosBD['apellido'],$usuariosBD['edad']);
    }

?>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Edad</th>
    </tr>

    <?php
    
        foreach ($usuarios as $usuario) {
            echo "<tr>";
            echo "<td>" . $usuario->getId() . "</td>";
            echo "<td>" . $usuario->getNombre() . "</td>";
            echo "<td>" . $usuario->getApellido() . "</td>";
            echo "<td>" . $usuario->getEdad() . "</td>";
            echo "</tr>";
        }
    ?>
</table>