<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use DateTime;
use Exception;

// use App\Models\UsuarioModel;
class RegisterController extends Controller
{
    public function index()
    {
        // Creamos la conexión y tenemos acceso a todas las consultas sql del modelo
        // $usuarioModel = new UsuarioModel();

        // // Se recogen los valores del modelo, ya se pueden usar en la vista
        // $usuarios = $usuarioModel->all();
        return $this->view('register.index'); // compact crea un array de índice usuarios
    }
    public function check()
    {
        $bandera = false;
        $comprobador = false;

        $csrf_token = isset($_POST['csrf_token']) ? $this->filtrado($_POST['csrf_token']) : '';

        // Validación del token CSRF
        if ($csrf_token !== $_SESSION['csrf_token']) {
            // die('Token CSRF inválido');
            $errores['csrf'] = "Error: Token CSRF inválido.";
            return $this->view('login.index', $errores);
        }

        $campos = ["user", "password"];
        $errores = [];

        // Recorremos cada campo esperado y aplicamos el filtrado y validación
        foreach ($campos as $campo) {
            // Si el campo está definido en $_POST, lo filtramos, si no, se le asigna una cadena vacía
            $$campo = isset($_POST[$campo]) ? $this->filtrado($_POST[$campo]) : '';
            // Validamos el campo y almacenamos el resultado en el array de errores
            $erroresCampo = $this->validarCampos($campo, $$campo);
            $errores = array_merge($errores, $erroresCampo);
        }

        foreach ($errores as $error) {
            if ($error != "") {
                $bandera = true;
            }
        }
        if ($bandera) {
            return $this->view('login.index', $errores);
        } else {
            $busquedaUser = new UsuarioModel();

            if ($busquedaUser->clear()->checkTableExists()) {

                $contrasena = $busquedaUser->clear()->select('contraseña')->WHERE("usuario", $user)->get();

                if (!empty($contrasena) ) {
                    if (password_verify($password, $contrasena[0]["contraseña"])) {
                        $_SESSION["nombre"]=$user;
                        return $this->redirect('../home');

                    }else{
                        $errores["password"] = "Contraseña Incorrecta";

                        return $this->view('login.index', $errores); 
                    }
                }else{
                    $errores["user"] = "Usuario Incorrecto";

                    return $this->view('login.index', $errores); 
                }
            } else {
                $errores["csrf"] = "No hay ningun usuario registrado";

                return $this->view('login.index', $errores);
            }
        }
    }

    public function register()
    {
        return $this->view('login.register');
    }

    function filtrado($datos): string
    {
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos);
        return $datos;
    }

    function validarCampos(String $input, String $cadena): array
    {
        $resultado = [];

        switch ($input) {

            case 'user':
                if (empty($cadena)) {
                    $resultado[$input] = "Debe de rellenar el campo nombre.";
                } 
                break;
            case 'password':
                if (empty($cadena)) {
                    $resultado[$input] = "Debe de rellenar el campo contraseña.";
                } else if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\s]).{8,}$/', $cadena)) {
                    $resultado[$input] = "Contraseña no valida.";
                }
                break;
        }

        return $resultado;
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

}
