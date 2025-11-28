<?php 
// Incluye el encabezado y navegación principal del sitio
require __DIR__ . '/../templates/header.php'; 
?>

<h2>Registrar videojuego</h2>

<?php 
// ------------------------------------------------------------
// MOSTRAR ERRORES DE VALIDACIÓN
// Si el controlador envía errores en el arreglo $errors,
// se muestran aquí para informar al usuario.
// ------------------------------------------------------------
?>
<?php if(!empty($errors ?? [])): ?>
<ul>
<?php foreach($errors as $err): ?>
<li><?=htmlspecialchars($err)?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php 
// ------------------------------------------------------------
// FORMULARIO PARA REGISTRAR UN NUEVO VIDEOJUEGO
// El método POST envía los datos al controlador,
// que se encarga de validarlos y guardarlos en la BD.
// ------------------------------------------------------------
?>

<form method="post" action="">

    <!-- Campo obligatorio: título del videojuego -->
    <label>
        Título:
        <input type="text" name="titulo" required>
    </label><br>
    <!-- Plataforma (PC, PlayStation, Xbox, etc.) -->
    <label>
        Plataforma:
        <input type="text" name="plataforma">
    </label><br>
    <!-- Género del videojuego (acción, aventura, etc.) -->
    <label>
        Género:
        <input type="text" name="genero">
    </label><br>
    <!-- Año de lanzamiento, rango permitido -->
    <label>
        Año:
        <input type="number" name="anio" min="1970" max="2100">
    </label><br>
    <!-- Precio del videojuego -->
    <label>
        Precio:
        <input type="number" step="0.01" name="precio">
    </label><br>
    <!-- Descripción larga -->
    <label>
        Descripción:
        <textarea name="descripcion"></textarea>
    </label><br>

    <!-- Botones de acción -->
    <div class="form-buttons">
        <button type="submit" class="button guardar">Guardar</button>

        <!-- Regresar al listado principal -->
        <a href="index.php" class="button volver">Volver</a>
    </div>

</form>

<?php 
// Incluye el pie de página del proyecto
require __DIR__ . '/../templates/footer.php'; 
?>
