<?php

namespace App\Controllers;

// use App\Models\UsuarioModel;
class LoginController extends Controller
{
    public function index()
    {
        // Creamos la conexión y tenemos acceso a todas las consultas sql del modelo
        // $usuarioModel = new UsuarioModel();

        // // Se recogen los valores del modelo, ya se pueden usar en la vista
        // $usuarios = $usuarioModel->all();
        return $this->view('login.index'); // compact crea un array de índice usuarios
    }
    public function check() {
        if($_POST['email'] == "hola" ){
            $errores['hola'] = "ok";
            $errores['adios'] = "si";
        }
        return $this->view('login.index', $errores);
    }
    public function register()
    {
        return $this->view('login.register');
    }

    public function store()
    {
        // Volvemos a tener acceso al modelo
        // $usuarioModel = new UsuarioModel();

        // Se llama a la función correpondiente, pasando como parámetro
        // $_POST
        // var_dump($_POST);
        // echo "Se ha enviado desde POST";

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
}
