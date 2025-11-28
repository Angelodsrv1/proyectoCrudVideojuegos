<?php
// Se importan el modelo y la clase de conexión
require_once __DIR__ . '/../models/Videojuego.php';
require_once __DIR__ . '/../config/Database.php';

class VideojuegoController {
    private $db;     // Variable que almacenará la conexión PDO
    private $model;  // Instancia del modelo Videojuego
    //  CONSTRUCTOR
    //  Aquí se crea la conexión y se inicializa el modelo
    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection();
        $this->model = new Videojuego($this->db);
    }
    //  LISTADO PRINCIPAL
    //  Maneja la búsqueda y el ordenamiento
    public function index() {
        if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
            // Limpiar cadenas y obtener el término buscado
            $query = trim($_GET['buscar']);
            // Llamar al modelo → función search()
            $stmt = $this->model->search($query);
            // Se obtienen todos los resultados encontrados
            $videojuegos = $stmt->fetchAll();
            // La búsqueda no mezcla ordenamientos dinámicos
            $currentSort = "id";
            $currentOrder = "ASC";
        } else {
            // LISTADO NORMAL CON ORDENAMIENTO
            $sort = $_GET['sort'] ?? 'id';
            if (!isset($_GET['order'])) {
                $order = 'ASC';
            } else {
                $order = ($_GET['order'] === 'ASC') ? 'DESC' : 'ASC';
            }
            // Se obtienen todos los registros ordenados
            $stmt = $this->model->getAll($sort, $order);
            $videojuegos = $stmt->fetchAll();
            // Guardar el orden actual para reflejarlo en la vista
            $currentSort = $sort;
            $currentOrder = $order;
        }

        // Se carga la vista del listado
        require __DIR__ . '/../views/videojuegos/list.php';
    }
    //  REGISTRAR NUEVO VIDEOJUEGO
    public function create(){

        // Si el usuario envió el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $errors = [];  // Array para guardar errores

            // Validación básica del título
            $titulo = trim($_POST['titulo'] ?? '');
            if($titulo === '') $errors[] = 'El título es obligatorio.';

            // Si no hay errores, se procede a guardar los datos
            if(empty($errors)){

                // Guardar propiedades en el modelo (sanitizadas)
                $this->model->titulo      = htmlspecialchars($titulo, ENT_QUOTES);
                $this->model->plataforma  = htmlspecialchars($_POST['plataforma'] ?? '', ENT_QUOTES);
                $this->model->genero      = htmlspecialchars($_POST['genero'] ?? '', ENT_QUOTES);
                $this->model->anio        = $_POST['anio'] ?: null;
                $this->model->precio      = $_POST['precio'] ?: 0.00;
                $this->model->descripcion = htmlspecialchars($_POST['descripcion'] ?? '', ENT_QUOTES);

                // Llamar al modelo para guardar en BD
                $this->model->create();

                // Redirigir para evitar reenvío del formulario
                header('Location: index.php');
                exit;
            }
        }

        // Si no hay POST, se carga el formulario de creación
        require __DIR__ . '/../views/videojuegos/create.php';
    }

    //  EDITAR UN VIDEOJUEGO EXISTENTE
    public function edit(){

        // Obtener ID por GET
        $id = $_GET['id'] ?? null;

        // Validación básica del ID
        if(!$id){
            header('Location: index.php');
            exit;
        }

        // Si el usuario ya envió el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Cargar ID
            $this->model->id = (int)$id;

            // Guardar datos sanitizados en el modelo
            $this->model->titulo      = htmlspecialchars($_POST['titulo'] ?? '', ENT_QUOTES);
            $this->model->plataforma  = htmlspecialchars($_POST['plataforma'] ?? '', ENT_QUOTES);
            $this->model->genero      = htmlspecialchars($_POST['genero'] ?? '', ENT_QUOTES);
            $this->model->anio        = $_POST['anio'] ?: null;
            $this->model->precio      = $_POST['precio'] ?: 0.00;
            $this->model->descripcion = htmlspecialchars($_POST['descripcion'] ?? '', ENT_QUOTES);

            // Actualizar en base de datos
            $this->model->update();

            // Redirigir al listado
            header('Location: index.php');
            exit;
        }

        // Obtener datos actuales del juego para llenar el formulario
        $videojuego = $this->model->getById($id);

        // Mostrar formulario de edición
        require __DIR__ . '/../views/videojuegos/edit.php';
    }

    //  ELIMINAR VIDEOJUEGO
    public function delete(){

        // Obtener id por GET
        $id = $_GET['id'] ?? null;

        // Si existe un ID válido → eliminar
        if($id){
            $this->model->delete($id);
        }

        // Redirigir siempre al final
        header('Location: index.php');
        exit;
    }

    //  MOSTRAR DETALLES EN UN MODAL
    public function show() {

        // Validar ID
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: index.php");
            exit;
        }

        // Obtener datos del videojuego único
        $videojuego = $this->model->getById($id);

        // Mostrar la vista con el modal
        require __DIR__ . '/../views/videojuegos/show.php';
    }
}
