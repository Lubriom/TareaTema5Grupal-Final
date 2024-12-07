<?php

namespace App\Controllers;
use Exception;

use App\Models\UsuarioModel;

class HomeController extends Controller
{
    // La página principal mostrará un listado de usuarios
    public function index()
    {
        return $this->view('home'); // Seleccionamos una vista (método padre)
    }

    public function crearTablas() {
        $usuarioModel = new UsuarioModel();

        try {
            $usuarioModel = $usuarioModel->getConnection();
            // $usuarioModel->beginTransaction();

            $usuarioModel->checkTableExists('usuario');
          
            // $usuarioModel->commit();
        } catch (Exception $e) {
            // $usuarioModel->rollBack();
            echo "Ha habido algún error!!: " . $e->getMessage();
        }

    }

    
}