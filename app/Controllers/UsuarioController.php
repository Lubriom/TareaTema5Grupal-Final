<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use Exception;
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

    public function show($id)
    {
        if ($id != $_SESSION["id"]) {
            return $this->view('panelControl.noAcceso');
        } else {
            $usuarioModel = new UsuarioModel();

            $usuario = $usuarioModel->clear()->select('*')->where("id", $id)->get();
            return $this->view('panelControl.index', $usuario);
        }
    }

    public function transaccion($id)
    {
        $bandera = false;
        $busquedaUser = new UsuarioModel();

        $csrf_token = isset($_POST['csrf_token']) ? $this->filtrado($_POST['csrf_token']) : '';

        // Validación del token CSRF
        if ($csrf_token !== $_SESSION['csrf_token']) {
            // die('Token CSRF inválido');
            $errores['csrf'] = "Error: Token CSRF inválido.";

            $usuario = $busquedaUser->clear()->select('*')->WHERE("id", $id)->get();
            $datos[] = $usuario[0];
            $datos[] = $errores;
            return $this->view('panelControl.index', $datos);
        }

        $campos = ["idDestino", "saldoEnvio"];
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

            $usuario = $busquedaUser->clear()->select('*')->WHERE("id", $id)->get();
            $datos[] = $usuario[0];
            $datos[] = $errores;
            return $this->view('panelControl.index', $datos);
        } else {

            $usuarioDestino = $busquedaUser->clear()->select('*')->WHERE("id", $idDestino)->get();
            $usuarioOrigen = $busquedaUser->clear()->select('*')->WHERE("id", $id)->get();

            if (!empty($usuarioDestino)) {
                if ($saldoEnvio > $usuarioOrigen[0]["saldo"]) {
                    $errores["saldoEnvio"] = "Intentas enviar mas saldo del que dispones";
                    $usuario = $busquedaUser->clear()->select('*')->WHERE("id", $id)->get();
                    $datos[] = $usuario[0];
                    $datos[] = $errores;
                    return $this->view('panelControl.index', $datos);
                } else {
                    $cantidadOrigen["saldo"] = $usuarioOrigen[0]["saldo"] - $saldoEnvio;
                    $cantidadDestino["saldo"] = $usuarioDestino[0]["saldo"] + $saldoEnvio;

                    try {
                        $usuarioModel = new UsuarioModel();
                        $conex = $usuarioModel->getConnection();

                        $conex->beginTransaction();

                        $usuarioModel->clear()->update($id, $cantidadOrigen);
                        $usuarioModel->clear()->update($idDestino, $cantidadDestino);

                        $conex->commit();
                    } catch (Exception $e) {
                        $conex->rollBack();
                        echo "Ha habido algún error!!: " . $e->getMessage();
                    }
                    $usuario = $busquedaUser->clear()->select('*')->WHERE("id", $id)->get();
                    $datos[] = $usuario[0];
                    return $this->view("panelControl.index", $datos);
                }
            } else {
                $errores["idDestino"] = "No existe ese usuario";
                $usuario = $busquedaUser->clear()->select('*')->WHERE("id", $id)->get();
                $datos[] = $usuario[0];
                $datos[] = $errores;
                return $this->view('panelControl.index', $datos);
            }
        }
    }

    public function listar()
    {
        $usuarioModel = new UsuarioModel();
        $cantidadUsuarios = $usuarioModel->contarRegistros()[0];
        $cantidadUsuarios = $cantidadUsuarios['TOTAL'];
        $usuarios = [];
        $cada = 5;

        $paginacion = $this->filtrado($_GET['p']);
        $paginacion = (is_numeric($paginacion)) ? $paginacion : 1;

        if ($paginacion <= 0 || ($paginacion * $cada) > $cantidadUsuarios) {
            header("Location: /usuarios?p=1");
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
        $bandera = false;
        $busquedaUser = new UsuarioModel();

        $csrf_token = isset($_POST['csrf_token']) ? $this->filtrado($_POST['csrf_token']) : '';

        // Validación del token CSRF
        if ($csrf_token !== $_SESSION['csrf_token']) {
            // die('Token CSRF inválido');
            $errores['csrf'] = "Error: Token CSRF inválido.";

            $usuario = $busquedaUser->clear()->select('*')->WHERE("id", $id)->get();
            $datos[] = $usuario[0];
            $datos[] = $errores;
            return $this->view('panelControl.index', $datos);
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

        foreach ($errores as $error) {
            if ($error != "") {
                $bandera = true;
            }
        }
        if ($bandera) {

            $usuario = $busquedaUser->clear()->select('*')->WHERE("id", $id)->get();
            $datos[] = $usuario[0];
            $datos[] = $errores;
            return $this->view('panelControl.index', $datos);
        } else {

            $usuario = $busquedaUser->clear()->select('*')->WHERE("id", $id)->get();

            if (!empty($usuario)) {

                if (!empty($nombre)) {
                    $update["nombre"] = $nombre;
                }
                if (!empty($apellidos)) {
                    $update["apellidos"] = $apellidos;
                }
                if (!empty($user)) {
                    $update["usuario"] = $user;
                }
                if (!empty($correo)) {
                    $update["correo"] = $correo;
                }
                if (!empty($fech_Nac)) {
                    $update["fecha_Nac"] = $fech_Nac;
                }
                if (!empty($saldo)) {
                    $update["saldo"] = $saldo;
                }
                if (!empty($update)) {
                    $busquedaUser->clear()->update($id, $update);

                    $datos = $busquedaUser->clear()->select('*')->WHERE("id", $id)->get();

                    $_SESSION["nombre"] = $datos[0]["usuario"];
                }

                return $this->view("panelControl.index", $datos);
            } else {
                $errores["user"] = "Error al intentar actualizar los datos";
                $usuario = $busquedaUser->clear()->select('*')->WHERE("id", $id)->get();
                $datos[] = $usuario[0];
                $datos[] = $errores;
                return $this->view('panelControl.index', $datos);
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
            case 'nombre':

                if (!empty($cadena)) {
                    if (preg_match('/^\d+(\.\d+)?$/', $cadena)) {
                        $resultado[$input] = "El nombre no puede ser de tipo numerico.";
                    } else if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚ]{1,20}$/', $cadena)) {
                        $resultado[$input] = "La longitud del nombre no puede ser superior a 20 caracteres.";
                    }
                }
                break;
            case 'apellidos':
                if (!empty($cadena)) {
                    if (preg_match('/^\d+(\.\d+)?$/', $cadena)) {
                        $resultado[$input] = "El apellido no puede ser de tipo numerico.";
                    }
                }
                break;
            case 'correo':
                if (!empty($cadena)) {
                    if (preg_match('/^\w+\@\w+\.php$/i', $cadena) || !filter_var($cadena, FILTER_VALIDATE_EMAIL)) {
                        $resultado[$input] = "Formato del email incorrecto.";
                    }
                }
                break;
            case 'fech_Nac':
                if (!empty($cadena)) {
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
                }
                break;
            case 'saldo':
                if (!empty($cadena)) {
                    if (!preg_match('/^\d+(\.\d+)?$/', $cadena)) {
                        $resultado[$input] = "Saldo no valida.";
                    } else if ((float)$cadena < 0) {
                        $resultado[$input] = "El saldo no puede ser negativo";
                    }
                }
                break;
            case 'idDestino':
                if (empty($cadena)) {
                    $resultado[$input] = "El id no puede estar vacio";
                } else if (!preg_match('/^(\d)+$/', $cadena)) {
                    $resultado[$input] = "El id debe ser de tipo entero";
                }
                break;
            case 'saldoEnvio':
                if (empty($cadena)) {
                    $resultado[$input] = "Debe de rellenar el campo saldo";
                } else if (!preg_match('/^\d+(\.\d+)?$/', $cadena)) {
                    $resultado[$input] = "Saldo no valido.";
                } else if ((float)$cadena < 0) {
                    $resultado[$input] = "El saldo no puede ser negativo";
                }
                break;
        }

        return $resultado;
    }



    public function destroy($id)
    {
        echo "Borrar usuario";
    }
}
