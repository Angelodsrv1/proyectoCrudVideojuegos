<?php 
// Incluye el encabezado general del sitio (estilos, menú, etc.)
require __DIR__ . '/../templates/header.php'; 
?>

<?php 
// =====================================================================
//  MODAL DE DETALLES DEL VIDEOJUEGO
//  Esta vista se abre cuando el usuario hace clic en "Ver" en la lista.
//  Muestra toda la información de un videojuego de forma resumida.
// =====================================================================
?>
<div id="modal" class="modal">
    <div class="modal-content">

        <!-- Botón para cerrar el modal y volver a la página principal -->
        <span class="close" onclick="window.location='index.php'">&times;</span>

        <h2>Detalles del videojuego</h2>
        <!-- 
            A continuación se muestran todos los datos del videojuego.
            htmlspecialchars() protege contra inyección de HTML.
            nl2br() conserva los saltos de línea en la descripción.
        -->
        <p><strong>Título:</strong> <?= htmlspecialchars($videojuego['titulo']) ?></p>

        <p><strong>Plataforma:</strong> <?= htmlspecialchars($videojuego['plataforma']) ?></p>

        <p><strong>Género:</strong> <?= htmlspecialchars($videojuego['genero']) ?></p>

        <p><strong>Año:</strong> <?= htmlspecialchars($videojuego['anio']) ?></p>

        <p><strong>Precio:</strong> $<?= htmlspecialchars($videojuego['precio']) ?></p>

        <p>
            <strong>Descripción:</strong><br>
            <?= nl2br(htmlspecialchars($videojuego['descripcion'])) ?>
        </p>

    </div>
</div>

<?php 
// Footer común del sitio
require __DIR__ . '/../templates/footer.php'; 
?>
