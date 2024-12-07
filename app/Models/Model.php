<?php

namespace App\Models;

use Exception;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Gestiona la conexión de la base de datos e incluye un esquema para
 * un Query Builder. Los return son ejemplo en caso de consultar la tabla
 * usuarios.
 */

class Model
{
    private string $db_host;
    private string $db_user;
    private string $db_pass;
    private string $db_name;

    private ?PDO $conex = null;

    private ?PDOStatement $query = null; // Consulta a ejecutar

    private string $select = '*';
    private ?string $where = null;
    private array  $values = [];
    private ?string $orderBy = null;
    private ?string $join = null;

    protected $table; // Definido en el hijo

    public function __construct()
    {
        $this->db_host = $_ENV['DB_HOST'];
        $this->db_user = $_ENV['DB_USER'];
        $this->db_pass = $_ENV['DB_PASS'];
        $this->db_name = $_ENV['DB_NAME'];

        try {
            $this->connection();
        } catch (Exception $e) {
            die('Error al inicializar la base de datos: ' . $e->getMessage());
        }
    }

    public function connection(): void
    {
        //Conexión a la base de datos.
        try {
            $this->query = null; // Consulta a ejecutar

            $dsn = "mysql:host={$this->db_host};dbname={$this->db_name}";
            $this->conex = new PDO($dsn, $this->db_user, $this->db_pass);
            $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Error al conectar con la base de datos:' . $e->getMessage());
        }
    }

    // QUERY BUILDER
    // Consultas: 

    // Recibe la cadena de consulta y la ejecuta
    public function query($sql, $data = [], $params = null): self
    {
        try {
            $smtp = $this->conex->prepare($sql);

            $smtp->execute($data);
            $this->query = $smtp;
        } catch (Exception $e) {
            die('Error en la consulta: ' . $e->getMessage());
        }

        return $this;
    }

    public function select(...$columns): self
    {
        // Separamos el array en una cadena con ,
        $this->select = implode(', ', $columns);

        return $this;
    }
    public function getAll(): array
    {
        try {
            return $this->query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Error al obtener los datos: ' . $e->getMessage());
        }
    }
    // Devuelve todos los registros de una tabla
    public function all(): array
    {
        try {
            $sql = "SELECT * FROM " . $this->table;
            $this->query($sql);
            return $this->query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error al obtener los registros: ' . $e->getMessage());
        }
    }

    // Consulta base a la que se irán añadiendo partes
    public function get(): array
    {
        try {
            if (empty($this->query)) {
                $sql = "SELECT {$this->select} FROM `{$this->table}`";

                // Se comprueban si están definidos para añadirlos a la cadena $sql
                if ($this->join) {
                    $sql .= " as {$this->table} INNER JOIN{$this->join}";
                }

                if ($this->where) {
                    $sql .= " WHERE {$this->where}";
                }

                if ($this->orderBy) {
                    $sql .= " ORDER BY {$this->orderBy}";
                }

                $this->query($sql, $this->values);
            }
        } catch (Exception $e) {
            die('Error en la consulta:' . $e->getMessage());
        }
        return $this->getAll();
    }

    public function find($id): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";

        $this->query($sql, [$id], '?');

        return $this->getAll();
    }

    // Se añade where a la sentencia con operador específico
    public function where($column, $operator, $value = null, $chainType = 'AND'): self
    {
        if ($value == null) { // Si no se pasa operador, por defecto =
            $value = $operator;
            $operator = '=';
        }

        // Si ya había algo de antes 
        if ($this->where) {
            $this->where .= " {$chainType} {$column} {$operator} ?";
        } else {
            $this->where = "{$column} {$operator} ?";
        }

        $this->values[] = $value;

        return $this;
    }

    // Se añade orderBy a la sentencia
    public function orderBy($column, $order = 'ASC')
    {
        if ($this->orderBy) {
            $this->orderBy .= ", {$column} {$order}";
        } else {
            $this->orderBy = "{$column} {$order}";
        }

        return $this;
    }

    // Insertar, recibimos un $_GET o $_POST
    // public function create($data): self
    // {
    //     try {
    //         $columns = array_keys($data); // array de claves del array
    //         $columns = implode(', ', $columns); // y creamos una cadena separada por ,

    //         $values = array_values($data); // array de los valores


    //         $sql = "INSERT INTO {$this->table} ({$columns}) VALUES (?" . str_repeat(', ? ', count($values) - 1) . ")";

    //         $this->query($sql, $values, '?');
    //     } catch (Exception $e) {
    //         die('Error al crear el registro:' . $e->getMessage());
    //     }

    //     return $this;
    // }

    public function create($tabla, $data): self
    {
        try {

            $this->createTable($data);


            // Crear las columnas y valores para la inserción
            $columns = array_keys($data);
            $columns = implode(', ', $columns);  // Creamos una cadena separada por comas

            $values = array_values($data);  // Los valores de las columnas

            // Construir la sentencia SQL para insertar
            $sql = "INSERT INTO {$this->table} ({$columns}) VALUES (?" . str_repeat(', ? ', count($values) - 1) . ")";

            // Ejecutar la consulta de inserción
            $this->query($sql, $values, '?');
        } catch (Exception $e) {
            die('Error al crear el registro:' . $e->getMessage());
        }

        return $this;
    }

    //Metodo para comprobar si una tabla existe
    //Calcula el numero de columnas de la tabla si es 0 es que no existe y si devulve un numero si existe
    public function checkTableExists($tabla)
    {
        $sql = "SHOW TABLES LIKE '{$tabla}'";  // Comprobamos si la tabla existe
        $result = $this->query($sql);  // Ejecutamos la consulta

        return $result > 0;  // Si devuelve filas, la tabla existe
    }

    private function createTable($columns)
    {
        // Comenzamos a construir la consulta CREATE TABLE
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (";

        // Iteramos sobre las columnas para añadirlas a la consulta
        $columnDefinitions = [];
        foreach ($columns as $column => $type) {
            // Ajustamos el tipo de dato y la definición de la columna
            // Aquí puedes agregar otras opciones como NOT NULL, DEFAULT, etc. si las necesitas
            $columnDefinitions[] = "{$column} {$type}";
        }

        // Unimos las definiciones de columnas por coma
        $sql .= implode(', ', $columnDefinitions);

        // Agregamos una columna ID autoincremental al final, si es necesario
        $sql .= ", id INT AUTO_INCREMENT PRIMARY KEY)";

        // Ejecutamos la consulta para crear la tabla
        $this->query($sql);
    }

    public function update($id, $data)
    {
        try {
            $fields = [];

            foreach ($data as $key => $value) {
                $fields[] = "{$key} = ?";
            }

            $fields = implode(', ', $fields);

            $sql = "UPDATE {$this->table} SET {$fields} WHERE id = ?";

            $values = array_values($data);
            $values[] = $id;

            $this->query($sql, $values);
        } catch (Exception $e) {
            die('Error al actualizar el registro: ' . $e->getMessage());
        }
        return $this;
    }

    public function join($table, $column1, $column2, $operator = "=", $chainType = 'ON')
    {
        try {
            if ($this->join) {
                $this->join .= " {$table} {$chainType} {$column1} {$operator} {$column2}";
            } else {
                $this->join = " {$table} {$chainType} {$column1} {$operator} {$column2}";
            }
        } catch (Exception $e) {
            die('Error en el método JOIN: ' . $e->getMessage());
        }
        return $this;
    }


    public function delete($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $this->query($sql, [$id], 'i');
        } catch (Exception $e) {
            die('Error al eliminar el registro: ' . $e->getMessage());
        }
    }
    public function getConnection(): ?PDO
    {
        return $this->conex;
    }
}
