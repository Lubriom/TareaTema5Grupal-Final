<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

// use App\Models\UsuarioModel;
class LoginController extends Controller
{
    public function index()
    {
        if(!isset($_SESSION['nombre'])){
            return $this->view('login.index'); 
        } else 
        return $this->redirect('/');
    }
    public function check()
    {
        $bandera = false;

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

        // Recorremos el array de error en busca de errores
        foreach ($errores as $error) {
            if ($error != "") {
                $bandera = true;
            }
        }
 
        // Si hay errores se regresa a la vista con el array de errores en otro caso inicia sesion
        if ($bandera) {
            return $this->view('login.index', $errores);
        } else {
            $busquedaUser = new UsuarioModel();

            // Comprobamos si la tabla existe antes de buscar el usuario
            if ($busquedaUser->clear()->checkTableExists()) {

                $datos = $busquedaUser->clear()->select('id', 'contraseña')->WHERE("usuario", $user)->get();

                if (!empty($datos)) {
                    if (password_verify($password, $datos[0]["contraseña"])) {
                        $_SESSION["nombre"] = $user;
                        $_SESSION["id"] = $datos[0]["id"];
                        return $this->redirect('../home');
                    } else {
                        $errores["password"] = "Contraseña Incorrecta";

                        return $this->view('login.index', $errores);
                    }
                } else {
                    $errores["user"] = "Usuario Incorrecto";

                    return $this->view('login.index', $errores);
                }
            } else {
                $errores["csrf"] = "No hay ningun usuario registrado";

                return $this->view('login.index', $errores);
            }
        }
    }

    private function filtrado($datos): string
    {
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos);
        return $datos;
    }

    private function validarCampos(String $input, String $cadena): array
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

    public function logout()
    {
        if(isset($_SESSION['nombre'])){
            session_destroy();
        return $this->redirect("home");
        }else 
        return $this->redirect('/home');
    }
}
