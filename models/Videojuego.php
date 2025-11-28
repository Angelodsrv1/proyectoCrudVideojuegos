<?php

// Modelo que maneja toda la comunicación con la tabla "videojuegos"
class Videojuego {

    private $conn;                // Conexión PDO a la BD
    private $table = 'videojuegos'; // Nombre de la tabla

    // Propiedades del registro
    public $id;
    public $titulo;
    public $plataforma;
    public $genero;
    public $anio;
    public $precio;
    public $descripcion;

    // ==========================================================
    // CONSTRUCTOR
    // Recibe la conexión desde el controlador
    // ==========================================================
    public function __construct($db){
        $this->conn = $db;
    }

    // ==========================================================
    // OBTENER TODOS LOS REGISTROS
    // ==========================================================
    public function getAll($sort = "id", $order = "ASC") {

        // Campos permitidos para ordenar (seguridad)
        $allowed = ["id", "titulo", "plataforma", "genero", "anio", "precio"];

        // Validar que el sort sea permitido
        if (!in_array($sort, $allowed)) $sort = "id";

        // Validar que el orden sea correcto
        if ($order !== "ASC" && $order !== "DESC") $order = "ASC";

        // Consulta dinámica con ORDER BY
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY $sort $order");
        $stmt->execute();

        return $stmt; // Retorna el resultado para ser usado en el controlador
    }

    // ==========================================================
    // BÚSQUEDA GENERAL (título, plataforma o género)
    // ==========================================================
    public function search($query) {

        // Búsqueda simple usando LIKE
        $sql = "SELECT * FROM {$this->table} 
                WHERE titulo     LIKE :q1
                OR plataforma    LIKE :q2
                OR genero        LIKE :q3
                ORDER BY id ASC";

        $stmt = $this->conn->prepare($sql);

        // %texto% para buscar coincidencias parciales
        $q = "%$query%";

        // Se enlaza en los tres campos buscables
        $stmt->bindValue(':q1', $q);
        $stmt->bindValue(':q2', $q);
        $stmt->bindValue(':q3', $q);

        $stmt->execute();
        return $stmt;
    }

    // ==========================================================
    // OBTENER UN SOLO VIDEOJUEGO POR ID
    // ==========================================================
    public function getById($id){

        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");

        // Bind del parámetro ID
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        // Devuelve un solo registro
        return $stmt->fetch();
    }

    // ==========================================================
    // CREAR NUEVO REGISTRO
    // ==========================================================
    public function create(){

        $sql = "INSERT INTO {$this->table} 
                (titulo, plataforma, genero, anio, precio, descripcion) 
                VALUES 
                (:titulo, :plataforma, :genero, :anio, :precio, :descripcion)";

        $stmt = $this->conn->prepare($sql);

        // Se enlazan los valores del objeto
        $stmt->bindParam(':titulo',      $this->titulo);
        $stmt->bindParam(':plataforma',  $this->plataforma);
        $stmt->bindParam(':genero',      $this->genero);
        $stmt->bindParam(':anio',        $this->anio);
        $stmt->bindParam(':precio',      $this->precio);
        $stmt->bindParam(':descripcion', $this->descripcion);

        return $stmt->execute(); // Retorna true o false
    }

    // ==========================================================
    // ACTUALIZAR UN REGISTRO EXISTENTE
    // ==========================================================
    public function update(){

        $sql = "UPDATE {$this->table} SET 
                    titulo      = :titulo,
                    plataforma  = :plataforma,
                    genero      = :genero,
                    anio        = :anio,
                    precio      = :precio,
                    descripcion = :descripcion
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        // Enlazar datos actualizados
        $stmt->bindParam(':titulo',      $this->titulo);
        $stmt->bindParam(':plataforma',  $this->plataforma);
        $stmt->bindParam(':genero',      $this->genero);
        $stmt->bindParam(':anio',        $this->anio);
        $stmt->bindParam(':precio',      $this->precio);
        $stmt->bindParam(':descripcion', $this->descripcion);

        // ID a actualizar
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // ==========================================================
    // ELIMINAR REGISTRO POR ID
    // ==========================================================
    public function delete($id){

        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");

        // Enlazar el ID
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
