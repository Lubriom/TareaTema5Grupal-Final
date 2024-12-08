<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use DateTime;

class UsuarioController extends Controller
{
    public function index()
    {
        // Creamos la conexión y tenemos acceso a todas las consultas sql del modelo
        $usuarioModel = new UsuarioModel();

        // Se recogen los valores del modelo, ya se pueden usar en la vista
        $usuarios = $usuarioModel->all();

        return $this->view('usuarios.index', $usuarios); // compact crea un array de índice usuarios
    }

    public function create()
    {
        $usuarioModel = new UsuarioModel();

        $datos = ["nombre" => "VARCHAR(100)", "apellidos" => "VARCHAR(100)", "usuario" => "VARCHAR(100)", "correo" => "VARCHAR(100)", "fecha_Nac" => "DATETIME", "contraseña" => "VARCHAR(100)", "saldo" => "DECIMAL(20)"];

        $usuarioModel->createTable($datos);

        $nombre = ["Juan", "María", "Carlos", "Lucía", "Pedro", "Ana", "Luis", "Elena", "Miguel", "Sofía"];
        $apellido = ["Pérez", "García", "López", "Hernández", "Gómez", "Sánchez", "Ramírez", "Ortega", "Ruiz", "Fernández"];
        $usuario = ["juanpg", "mlopez", "chernandez", "lgomez", "pedror", "ana92", "luism", "elena98", "miguel88", "sofia99"];
        $correo = ["example.com", "test.com", "email.com", "mail.net", "site.org"];
        $fecha_Nac = ["1980-01-01", "1990-05-15", "1995-07-20", "2000-12-30", "1985-03-25", "1998-10-10", "1992-06-18", "1988-09-22", "1997-04-12", "2001-08-09"];
        $contrasena = ["1A2a3a4a."];
        $saldo = [85.85, 50.75, 100.50, 250.00, 500.25, 999.99, 20.00, 75.25, 300.00, 400.50];

        for ($i = 0; $i < 100; $i++) {
            $datos = [];
            $datos["nombre"] = $nombre[array_rand($nombre)];
            $datos["apellidos"] = $apellido[array_rand($apellido)];
            $datos["usuario"] = $usuario[array_rand($usuario)] . $i;
            $datos["correo"] = $correo[array_rand($correo)];
            $fecha = new DateTime($fecha_Nac[array_rand($fecha_Nac)]);
            $datos["fecha_Nac"] = $fecha->format('Y-m-d');;
            $datos["contraseña"] = password_hash($contrasena[array_rand($contrasena)], PASSWORD_DEFAULT);
            $datos["saldo"] = $saldo[array_rand($saldo)];

            $usuarioModel->insertar($datos);
        }
        return $this->redirect('home');
    }

    public function show()
    {
        $usuarioModel = new UsuarioModel();
        $cantidadUsuarios = $usuarioModel->contarRegistros()[0];
        $cantidadUsuarios = $cantidadUsuarios['TOTAL'];
        $usuarios = [];
        $cada = 5;

        $paginacion = $this->filtrado($_GET['page']);
        $paginacion = (is_numeric($paginacion)) ? $paginacion : 1;

        if ($paginacion <= 0 || ($paginacion * $cada) > $cantidadUsuarios) {
            header("Location: /usuarios?page=1");
        }
        $desde = ($paginacion - 1) * $cada;
        $usuarios = $usuarioModel->rows($cada, $desde);

        return $this->view('usuarios.show', $usuarios);
    }

    public function edit($id)
    {
        echo "Editar usuario";
    }

    public function update($id)
    {
        echo "Actualizar usuario";
    }

    public function destroy($id)
    {
        echo "Borrar usuario";
    }

    // Función para mostrar como fuciona con ejemplos
    private function filtrado($datos): string
    {
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos);
        return $datos;
    }

    private function validarCampos(String $campo): string
    {
        $resultado = "";

        if (is_nan($campo)) {
            $resultado = "Error: No se ha recibido un numero";
        }

        return $resultado;
    }
}
