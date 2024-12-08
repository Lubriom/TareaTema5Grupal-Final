<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

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
            return $this->view('register.index', $errores);
        }

        $campos = ["nombre", "apellidos", "user", "correo", "fech_Nac", "password", "saldo"];
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

        // Si hay errores se regresa a la vista con el array de errores
        if ($bandera) {
            return $this->view('register.index', $errores);
        } else {
            $busquedaUser = new UsuarioModel();

            // Comprobamos si la table existe en cas contrario la creamos
            if (!$busquedaUser->clear()->checkTableExists()) {
                $datos = ["nombre" => "VARCHAR(100)", "apellidos" => "VARCHAR(100)", "usuario" => "VARCHAR(100)", "correo" => "VARCHAR(100)", "fecha_Nac" => "DATETIME", "contraseña" => "VARCHAR(100)", "saldo" => "DECIMAL(20)"];

                $busquedaUser->clear()->createTable($datos);
            }

            // Buscamos si el nombre de usuario no existe en la base de datos
            $usuario = $busquedaUser->clear()->select('*')->WHERE("usuario", $user)->get();

            // Una vez buscado preparamos los datos para insertarlo en la tabla
            if (empty($usuario)) {

                $register["nombre"] = $nombre;
                $register["apellidos"] = $apellidos;
                $register["usuario"] = $user;
                $register["correo"] = $correo;
                $register["fecha_Nac"] = $fech_Nac;
                $register["contraseña"] = password_hash($password,PASSWORD_DEFAULT);
                $register["saldo"] = $saldo;

                $busquedaUser->clear()->insertar($register);

                $datos = $busquedaUser->clear()->select('id')->WHERE("usuario", $user)->get();

                $_SESSION["nombre"] = $user;
                $_SESSION["id"] = $datos[0]["id"];

                return $this->redirect("../home");
            } else {
                $errores["user"] = "Ese usuario ya existe";

                return $this->view('register.index', $errores);
            }
        }
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
            case 'nombre':
                if (empty($cadena)) {
                    $resultado[$input] = "Debe de rellenar el campo nombre.";
                } else if (preg_match('/^\d+(\.\d+)?$/', $cadena)) {
                    $resultado[$input] = "El nombre no puede ser de tipo numerico.";
                } else if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚ]{1,20}$/', $cadena)) {
                    $resultado[$input] = "La longitud del nombre no puede ser superior a 20 caracteres.";
                }
                break;
            case 'apellidos':
                if (empty($cadena)) {
                    $resultado[$input] = "Debe de rellenar el campo apellidos.";
                } else if (preg_match('/^\d+(\.\d+)?$/', $cadena)) {
                    $resultado[$input] = "El apellido no puede ser de tipo numerico.";
                }
                break;
            case 'user':
                if (empty($cadena)) {
                    $resultado[$input] = "Debe de rellenar el campo nombre.";
                }
                break;
            case 'correo':
                if (preg_match('/^\w+\@\w+\.php$/i', $cadena) || !filter_var($cadena, FILTER_VALIDATE_EMAIL)) {
                    $resultado[$input] = "Formato del email incorrecto.";
                }
                break;
            case 'fech_Nac':
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $cadena)) {

                    list($anio, $mes, $dia) = explode('-', $cadena);

                    $resultado[$input] = (checkdate((int)$mes, (int)$dia, (int)$anio)) ? "" : "Error al introducir la fecha";
                } else {
                    $resultado[$input] = "Error al introducir la fecha.";
                }
                $hoy = date("Y-m-d");

                if ($cadena > $hoy) {
                    $resultado[$input] = "Error al introducir la fecha";
                }

                break;
            case 'password':
                if (empty($cadena)) {
                    $resultado[$input] = "Debe de rellenar el campo contraseña.";
                } else if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\s]).{8,}$/', $cadena)) {
                    $resultado[$input] = "Contraseña no valida.";
                }
                break;
            case 'saldo':
                if (empty($cadena)) {
                    $resultado[$input] = "Debe de rellenar el campo saldo";
                } else if (!preg_match('/^\d+(\.\d+)?$/', $cadena)) {
                    $resultado[$input] = "Saldo no valido.";
                }else if((float)$cadena<0){
                    $resultado[$input] = "El saldo no puede ser negativo";
                }
                break;
        }

        return $resultado;
    }
}
