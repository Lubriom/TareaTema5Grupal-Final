<?php
// app/Gestion/Usuario.php
namespace App\Gestion;

class Usuario {
    private $id;
    private $nombre;
    private $apellido;
    private $edad;

    // Constructor para inicializar los valores
    public function __construct($id, $nombre, $apellido, $edad) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->edad = $edad;
    }

    // Métodos getters para acceder a las propiedades
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getEdad() {
        return $this->edad;
    }
}
