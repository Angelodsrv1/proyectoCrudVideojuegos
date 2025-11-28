<?php 
// Incluye el encabezado con estilos y menú
require __DIR__ . '/../templates/header.php'; 
?>

<h2>Editar videojuego</h2>

<?php 
// ------------------------------------------------------------
// FORMULARIO DE EDICIÓN
// Este formulario carga los datos actuales del videojuego,
// permitiendo modificarlos y enviarlos nuevamente al controlador.
// ------------------------------------------------------------
?>
<form method="post" action="">

    <!-- Campo: Título del videojuego (obligatorio) -->
    <label>
        Título:
        <input type="text" name="titulo" 
               value="<?= htmlspecialchars($videojuego['titulo'] ?? '') ?>" required>
    </label>
    <!-- Campo: Plataforma -->
    <label>
        Plataforma:
        <input type="text" name="plataforma" 
               value="<?= htmlspecialchars($videojuego['plataforma'] ?? '') ?>">
    </label>
    <!-- Campo: Género del videojuego -->
    <label>
        Género:
        <input type="text" name="genero" 
               value="<?= htmlspecialchars($videojuego['genero'] ?? '') ?>">
    </label>
    <!-- Campo: Año de lanzamiento -->
    <label>
        Año:
        <input type="number" name="anio" min="1970" max="2100" 
               value="<?= htmlspecialchars($videojuego['anio'] ?? '') ?>">
    </label>
    <!-- Campo: Precio -->
    <label>
        Precio:
        <input type="number" step="0.01" name="precio" 
               value="<?= htmlspecialchars($videojuego['precio'] ?? '') ?>">
    </label>
    <!-- Campo: Descripción detallada -->
    <label>
        Descripción:
        <textarea name="descripcion"><?= htmlspecialchars($videojuego['descripcion'] ?? '') ?></textarea>
    </label>
    <!-- Botón para guardar cambios -->
    <button type="submit">Actualizar</button>
    <!-- Botón para volver al listado general -->
    <a href="index.php" class="button">Volver</a>


</form>


<?php 
// Incluye el pie de página
require __DIR__ . '/../templates/footer.php'; 
?>