<?php
// index.php — Archivo principal del proyecto (punto de entrada)

// Importamos el controlador que manejará todas las acciones del CRUD
require_once __DIR__ . '/controllers/VideojuegoController.php';

// ==========================================================
// CREAR INSTANCIA DEL CONTROLADOR
// El controlador gestionará todas las operaciones del sistema:
// listar, crear, editar, eliminar y ver detalles.
// ==========================================================
$controller = new VideojuegoController();

// ==========================================================
// LEER LA ACCIÓN DESDE LA URL
// Ejemplo: index.php?action=create
// Si no se envía nada, se usa "index" (mostrar lista)
// ==========================================================
$action = $_GET['action'] ?? 'index';

// ==========================================================
// ENRUTAMIENTO SIMPLE
// Según la acción en la URL, llamamos al método correspondiente
// del controlador.
// ==========================================================
switch($action){

    case 'create':     // Mostrar formulario o guardar nuevo registro
        $controller->create();
        break;

    case 'edit':       // Editar un videojuego ya existente
        $controller->edit();
        break;

    case 'delete':     // Eliminar un videojuego por ID
        $controller->delete();
        break;
        
    case 'show':       // Mostrar detalles del videojuego (modal)
        $controller->show();
        break;

    // Si no coincide con ninguna acción, se muestra la lista
    default:
        $controller->index();
        break;
}
