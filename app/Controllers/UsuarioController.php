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
        $usuarios = $usuarioModel->consultaPrueba();

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
        $contrasena = ["password123", "123456", "securepass", "mypassword", "qwerty", "pass2024", "letmein", "admin123", "welcome", "trustno1"];
        $saldo = [85.85, 50.75, 100.50, 250.00, 500.25, 999.99, 20.00, 75.25, 300.00, 400.50];

        for ($i = 0; $i < 100; $i++) {
            $datos = [];
            $datos["nombre"] = $nombre[array_rand($nombre)];
            $datos["apellidos"] = $apellido[array_rand($apellido)];
            $datos["usuario"] = $usuario[array_rand($usuario)];
            $datos["correo"] = $correo[array_rand($correo)];
            $fecha = new DateTime($fecha_Nac[array_rand($fecha_Nac)]);
            $datos["fecha_Nac"] = $fecha->format('Y-m-d');;
            $datos["contraseña"] = password_hash($contrasena[array_rand($contrasena)], PASSWORD_DEFAULT);
            $datos["saldo"] = $saldo[array_rand($saldo)];

            $usuarioModel->insertar($datos);
        }
        return $this->redirect('home');
    }

    public function store()
    {
        // Volvemos a tener acceso al modelo
        $usuarioModel = new UsuarioModel();

        // Se llama a la función correpondiente, pasando como parámetro
        // $_POST
        var_dump($_POST);
        echo "Se ha enviado desde POST";

        // Podríamos redirigir a donde se desee después de insertar
        //return $this->redirect('/contacts');
    }

    public function show($id)
    {
        echo "Mostrar usuario con id: {$id}";
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
    public function pruebasSQLQueryBuilder()
    {
        // Se instancia el modelo
        $usuarioModel = new UsuarioModel();
        // Descomentar consultas para ver la creación
        //$usuarioModel->all();
        //$usuarioModel->select('columna1', 'columna2')->get();
        // $usuarioModel->select('columna1', 'columna2')
        //             ->where('columna1', '>', '3')
        //             ->orderBy('columna1', 'DESC')
        //             ->get();
        // $usuarioModel->select('columna1', 'columna2')
        //             ->where('columna1', '>', '3')
        //             ->where('columna2', 'columna3')
        //             ->where('columna2', 'columna3')
        //             ->where('columna3', '!=', 'columna4', 'OR')
        //             ->orderBy('columna1', 'DESC')
        //             ->get();
        //$usuarioModel->create(['id' => 1, 'nombre' => 'nombre1']);
        //$usuarioModel->delete(['id' => 1]);
        //$usuarioModel->update(['id' => 1], ['nombre' => 'NombreCambiado']);

        echo "Pruebas SQL Query Builder";
    }
}
